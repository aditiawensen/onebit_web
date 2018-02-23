
<div class="w3-row">
	<div class="w3-row" style="position:absolute;height:100%;overflow:auto">
		 <div class="w3-col m3">&nbsp;</div>
		 <div class="w3-col m9 w3-padding-small">
			<div id="body-content" class="w3-row"></div>
			<br>
			<br>
			<br>
		</div>
	</div>
	<div class="w3-col m3 w3-padding">
		<div class="w3-row w3-center w3-padding" style="background:rgba(0,100,255,.3)">
			<h1>Total Pengguna</h1>
			<div class="w3-row" style="background:rgba(0,100,255,.1)">
				<span id="total-pengguna" class="w3-xxxlarge"></span>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var tp = 0;
	$.getJSON("http://onebit.asia/data/select-pengguna.php",function(result){
		$.each(result,function(i,data){
			var c = `<div class="w3-col m2">
					    <div class="w3-row">
					        <div class="w3-padding-small w3-center">
					            <img class="imgpengguna" src="http://onebit.asia/data/aw-uploads/profile/`+data.gambar_pengguna+`" style="width:100%;object-fit:cover;object-position:center">
					             <div class="w3-row w3-center" style="white-space:nowrap">
						        	<span class="w3-tiny">`+data.nama_pengguna+`</span>
						        </div>
					        </div>
					    </div>
					</div>`;
			$('#body-content').append(c);
	       	tp++;
		});
		$('#total-pengguna').text(tp);	
		var cw = $('.imgpengguna').width();
		$('.imgpengguna').css({'height':cw+'px'});	
	});
</script>