<div id="subpage_body">
	<div id="subpage_left">
		<?= GoodText::formated($page->content);?>
		<?= Form::open(null, array('id'=>'contact_form'));?>
		<?= Form::label('content', 'Treść wiadomości');?>
		<?= Form::textarea('content', $data['content'], array('id'=>'content'));?>
		<?= Form::label('sender', 'Podaj swój e-mail');?>
		<?= Form::input('sender', $data['sender'], array('id'=>'sender'));?>
		<?= Form::submit('submit_contact', 'Wyślij');?>
		<div style="clear: both;"></div>
		<?= Form::close();?>			
	</div>
	<div id="subpage_right">
		<div id="map"></div>
	</div>
	<script type="text/javascript">
	(function() {

        var geocoder = new google.maps.Geocoder();
        var address = 'ul. Stołeczna 7 lok. 100, Białystok, POLAND';
        var loc;
        if (geocoder) {
            geocoder.geocode({ 'address': address }, function (results, status) {

	            if (status == google.maps.GeocoderStatus.OK) {
	
	            	loc = results[0].geometry.location;
	                var latlng = loc;
	                var myOptions = {
	           	        zoom: 15,
	                    center: latlng,
	                    mapTypeId: google.maps.MapTypeId.ROADMAP
	                };
	                map = new google.maps.Map($('map'), myOptions);
	                var marker = new google.maps.Marker({
	           	        position: latlng,
	                    map: map,
	                    title: "Dia-Bakter Diagnostyka Laboratoryjna-Mikrobiologia Katarzyna Leszczyńska (skrót: Dia-Bakter)"
	                });
	            } 
            });
        }
    
	
	})();
</script>	
</div>
<div style="clear:both;"></div>