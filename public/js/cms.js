$(document).ready(function() {

    // Bind delete prompts
    $('.delete').click(function(event) {
        event.preventDefault();
        var href = this.href;
        $('#modalPromptDo').click(function(event) {
            window.location.replace(href);
	});
        $('#modalPrompt').modal('show');        
    });
    
    
    // Bind datepicker for publication date	
    $('#publication_date').datepicker({
        inline: true,
        dateFormat: 'yy-mm-dd'
    });

    function bindUpload()
    {
	if ($('.filesupload'))
	{
	    function showAddNextButton() {
		$('.filesupload .item .add').hide();
		$('.filesupload .item .add').last().show();
	    }
	    
	    $('.filesupload .add').click(function(event) {
		event.preventDefault();
		$('.filesupload').append('<div class="item span7"><div class="fileupload pull-left fileupload-new" data-provides="fileupload"><div class="fileupload-preview uneditable-input"></div><span class="btn btn-file"><span class="fileupload-new">Wybierz plik</span><span class="fileupload-exists">Zmień</span>     <input type="file" name="files[]"/></span>           <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Usuń</a>      </div>  <div class="toolbox pull-left">            <a href="#" class="btn add">Dodaj kolejny</a>            <a href="#" class="btn del btn-danger">Usuń</a>     </div></div>');	
		showAddNextButton();
		bindUpload();
	    });
	    $('.filesupload .del').click(function(event) {
		event.preventDefault();
		$(event.target).parent().parent().remove();
		showAddNextButton();
	    });
	}
    }
    bindUpload();
});