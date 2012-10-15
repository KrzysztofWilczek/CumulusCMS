$(document).ready(function() {
	/* Main request handler */
	this.xhr_request;
	var self = this;
	
	/* Loader init */
	function initLoader(appender, message) {
		if(!message) {
			message = 'Loading...'
		}
		overlay = $('<div id="overlay"><span class="bg"></span><div>'+message+'</div></div>');
		appender.append(overlay);
		overlay.animate({
			opacity: 1
		}, 800);
	}
	
	/* Loader off */
	function closeLoader() {
		$('#overlay').remove();
	}
	
	/* Results reloader */
	function reloadResults(response) {
		data = $(response.data);
		$('#reloaded').children().remove();
		$('#reloaded').append(data);
		$('#pagination').attr('id', 'pagination_old');
		pagination = $(response.pagination);
		if(!pagination[0] || !pagination) {
			pagination = $('<div id="pagination"></div>');
		}
		$('#pagination_old').replaceWith(pagination);
		rowEffectEvent();
		paginationEvent();
		$('*[rel="tooltip"]').tooltip();
	}
	
	/**
	 * Events section
	 */
	
	/* Search event (live search) */
	function searchEvent() {
		search = $('#search_form');
		$(document).keyup(function(e) {
			
			query = search.serialize();
			
			if(self.xhr_request) {
				self.xhr_request.abort();
			}
			self.xhr_request = $.ajax({
				url: document.location.href,
				data: query,
				dataType: 'json',
				beforeSend: function() {
					initLoader($('#reloaded'));
				},
				success: function(response) {
					reloadResults(response);
					closeLoader();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					if(textStatus == 'abort') {
						closeLoader();
					}
				}
			});
		});	
	}
	
	/* Items per page events */
	function perPageEvent() {
		perpage = $('#perpage');
		list = perpage.children().children('li');
		elements = perpage.children().children('li').children('a');
		elements.click(function(e) {
			e.preventDefault();
			self = this;
			if(self.xhr_request) {
				self.xhr_request.abort();
			}
			self.xhr_request = $.ajax({
				url: $(self).attr('href'),
				dataType: 'json',
				beforeSend: function() {
					initLoader($('#reloaded'));
				},
				success: function(response) {
					reloadResults(response);
					closeLoader();
					list.removeClass('active');
					$(self).parent('li').addClass('active');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					if(textStatus == 'abort') {
						closeLoader();
					}
				}
			});
		});
	}
	
	/* Standard pagination */
	function paginationEvent() {
		pagination = $('#pagination');
		pagi_items = pagination.children('ul').children('li').children('a');
		$.each(pagi_items, function(key, item) {
			item = $(item);
			if(item.attr('href') != '#') {
				item.click(function(e) {
					e.preventDefault();
					if(self.xhr_request) {
						self.xhr_request.abort();
					}
					self.xhr_request = $.ajax({
						url: $(this).attr('href'),
						dataType: 'json',
						beforeSend: function() {
							initLoader($('#reloaded'));
						},
						success: function(response) {
							reloadResults(response);
							closeLoader();
						},
						error: function(jqXHR, textStatus, errorThrown) {
							if(textStatus == 'abort') {
								closeLoader();
							}
						}
					});
				});
			}
		});
	}
	
	/* Hover event for all rows in the table */
	function rowEffectEvent() {
		rows = $('#reloaded').children('tr');
		rows.hover(function(e) {
			e.preventDefault();
			$(this).children('td').children('a').removeClass('disabled');
		}, function(e) {
			e.preventDefault();
			$(this).children('td').children('a').addClass('disabled');
		});
	}
	
	function sorterEvent() {
		headings = $('a.sortHeader');
		headings.click(function(e) {
			e.preventDefault();
			if(self.xhr_request) {
				self.xhr_request.abort();
			}
			a = this;
			self.xhr_request = $.ajax({
				url: $(this).attr('href'),
				dataType: 'json',
				beforeSend: function() {
					initLoader($('#reloaded'));
				},
				success: function(response) {
					reloadResults(response);
					closeLoader();
					$(a).attr('href', '/'+response.order);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					if(textStatus == 'abort') {
						closeLoader();
					}
				}
			});
		});
	}
	
	/**
	 * Attach events section
	 */
	
	searchEvent();
	perPageEvent();
	paginationEvent();
	rowEffectEvent();
	sorterEvent();

});