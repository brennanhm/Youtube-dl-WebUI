$(document).ready(function() {

	$("#vidcont").click(function() {
		$("#invalidurl").hide();
		var vidurl = $("#url").val();
		if(/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(vidurl)){
			// Valid URL
		} else {
			$("#invalidurl").show();
			return false;
		}
		$("#spinner1").show();
		$.ajax
		({
			type: "GET",
			url: "class/VideoInfo.php",
			data: { url: vidurl },
			dataType: 'json',
			cache: false,
			success: function(data)
			{
				jQuery.each(data.vidformats, function(index, item) {
					$('#' + item).attr("style", "display: inline; padding: 5px;");
				});
				$("#mp3").attr("style", "display: inline; padding: 5px;");
				$("#vidtitle").text(data.vidinfo[0]);
				$("#vidimg").attr("src", data.vidinfo[1]);
				$("#vidcont").hide();
				$("#spinner1").hide();
				$("#url").attr("disabled", "disabled");
				$("#vidtitle").show();
				$("#vidthumb").show();
				$("#formatlbl").show();
				$("#formatbtns").show();
				// $("#viddown").show();
				$("#viddown").show();
				$("#vidcanc").show();
			}
		});

	});

	$("#viddown").click(function() {
		$("#downloadbar").show();
		var vidurl = $("#url").val();
		var vidfmt = $("form input[name=format]:checked").val()
		
		$.post('index.php', { urls: vidurl, format: vidfmt }, 
			function(returnedData){
		});

		function checkProgress() {
			$.ajax
			({
				type: "GET",
				url: "class/CheckStatus.php",
				data: { url: vidurl, format: vidfmt },
				dataType: 'json',
				cache: false,
				success: function(data)
				{
					//alert("Exists: " + data.exists);
					//alert("Filename: " + data.filename);
					if(data.exists === "yes") {
						filenameurl = "downloads/" + data.filename
						$("#viddown").hide();
						$("#vidcanc").hide();
						$("#downloadbar").hide();
						$("#vidlink").attr("href", filenameurl);
						$("#vidlink").show();
						$("#vidrestart").show();
						$("#downloadready").attr("style", "display: inline; padding: 5px");
						clearInterval(checkIntervalId);
					}
				}
			});
		}
		checkIntervalId = setInterval(checkProgress, 5000);

	});

	$("#vidcanc").click(function() {
		if (typeof checkIntervalId != "undefined") {
			clearInterval(checkIntervalId);
		}
		$.get('index.php', { kill: "all" },
			function(returnedData) {
		});
		clearElements();
	});

	$("#vidrestart").click(function() {
		clearElements();
	});

	$('#download-form').submit(function (e) {
		e.preventDefault();
		return false;
	});

	// Prevent enter key from submitting request
	$("#url").keypress(function(event) {
		if (event.keyCode == 13) {
		    event.preventDefault();
		}
	});

	$(".radiobutton").click(function() {
		$("#vidlink").hide();
		$("#vidrestart").hide();
		$("#downloadready").hide();
		$("#viddown").show();
		$("#vidcanc").show();
	});

	function clearElements() { 
		$(".radiobutton").hide();
		$("#vidthumb").hide();
		$("#viddown").hide();
		$("#vidcanc").hide();
		$("#vidtitle").hide();
		$("#checkboxdiv").hide();
		$("#downloadbar").hide();
		$("#vidlink").hide();
		$("#vidrestart").hide();
		$("#downloadready").hide();
		$("#vidcont").show();
		$("#url").removeAttr("disabled");
		$("#url").val("");
	 }

});
