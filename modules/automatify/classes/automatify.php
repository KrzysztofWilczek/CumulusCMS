<?php 
class Automatify {
	
	protected $perPage;
	protected $query;
	protected $order;
	protected $pagination;
	protected $searchColumns;
	protected $searchQuery;
	protected $offset;
	protected $config;
        public $currentItems;
	
	public function __construct($query, $searchColumns, $order = array('id' => 'DESC')) {
		
		$this->config = Kohana::$config->load('automatify');
		
		$per_page = Request::initial()->query('perpage');
		$user_order = Request::initial()->query('order');
		$user_order_type = Request::initial()->query('order_type');
		$this->query = $query;
		$this->searchColumns = $searchColumns;
		if(empty($user_order) || empty($user_order_type)) {
			$this->order = $order;
		}
		else
                {
                        if(in_array(strtolower($user_order_type), array('asc', 'desc'))) {
				$this->order = array($user_order => $user_order_type);
			}
			else {
				$this->order = $order;
			}
		}
                
		$this->searchQuery = Request::current()->query('search_query');
                $this->perPage = $this->config['per_page'];
                $this->setSearchConditions();
                $this->configurePagination();
		$this->getRowsForCurrentPage();
		if(Request::initial()->is_ajax())
                {
                    $this->ajax();
                }
	}
	
        protected function setSearchConditions()
        {
            if(!empty($this->searchQuery)) {
			foreach($this->searchColumns as $column) {
                                $this->query->where($column, 'like', '%'.$this->searchQuery.'%');
			}
		}
		
        }
        
        protected function countTotal()
        {
            $query = $this->query;
            $result = $query->as_object()->execute();
            return count($result);
        }
        
	protected function configurePagination() {
		$config = array(
			'current_page'      => array('source' => 'query_string', 'key' => 'page'),
			'total_items'    	=> $this->countTotal(),
			'items_per_page' 	=> $this->perPage
		);
		$pagination = Pagination::factory($config);
		$this->offset = $pagination->offset;
		$this->pagination = $pagination;
	}
	
	public function getRowsForCurrentPage() {
		$this->query
			->limit($this->perPage)
			->offset($this->offset); 
		
		foreach($this->order as $by => $order) {
			$this->query->order_by($by, $order);
		}
                $query = $this->query;
                $this->currentItems = $query->as_object()->execute();
	}
	
	
	public function __toString() {
		return $this->pagination->__toString();
	}
	
	private function ajax() {
		$response = array();
                $viewPath = 'admin/'.Request::initial()->controller().'/_list';
                
		$response['data'] = (string)View::factory($viewPath)->set('items', $this->currentItems);
		$response['pagination'] = $this->pagination->__toString();
		$order_table = array_keys($this->order);
		$order_type = array_values($this->order);
		if(strtolower($order_type[0]) == 'desc') { $order_to_show = 'asc';	}
		else { $order_to_show = 'desc';	}
		$response['order'] = Request::initial()->current()->uri().URL::query(array('order' => $order_table[0], 'order_type' => $order_to_show));
		echo json_encode($response);
		die();
	}
	
	public static function perPageFilter($per_page) {
		switch($per_page) {
			case 10:
			case 20:
			case 50:
				return $per_page;
			break;
			default:
						
				$config = Kohana::$config->load('automatify');
				return $config['per_page'];
			break;
		}	
	}
	
	public function sortHeader($name, $table) {
	
		$order = array_values($this->order);
		if(strtolower($order[0]) == 'desc') {
			$order_to_show = 'asc';
		}
		else {
			$order_to_show = 'desc';
		}
		return html::anchor(Request::initial()->current()->uri().'?order='.$table.'&order_type='.$order_to_show, $name, array('class' => 'sortHeader'));
	}
	
}