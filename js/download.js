$(document).ready(function() {

	$("#vidcont").click(function() {
		$("#invalidurl").hide();
		var vidurl = $("#url").val();
		if(/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/|www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(vidurl)){
			// URL validation
		} else {
			$("#invalidurl").show();
			return false;
		}
		$("#spinner1").show();
		$.post('class/VideoTitle.php', { url: vidurl }, 
			function(returnedData){
				$("#vidtitle").text(returnedData);
				$("#vidtitle").show();
		});
		$.post('class/VideoThumbnail.php', { url: vidurl }, 
			function(returnedData){
				$("#vidcont").hide();
				$("#spinner1").hide();
				$("#url").attr("disabled", "disabled");
				$("#vidimg").attr("src", returnedData);
				$("#vidthumb").show();
				$("#viddown").show();
				$("#vidcanc").show();
		});
	});

	$("#viddown").click(function() {
		$("#downloadbar").show();
		var vidurl = $("#url").val();
		if ( $("#checkbx").is(':checked') ) {
			$.post('index.php', { urls: vidurl, audio: "true" }, 
				function(returnedData){
			});
		} else {
			$.post('index.php', { urls: vidurl }, 
				function(returnedData){
			});
		}
		var vidtitle = $("#vidtitle").text()
		var vidtitle2 = vidtitle.replace(/\ /g, '_'); // Replace spaces with underscores
		function checkProgress() {
			$.post('class/CheckStatus.php', { title: vidtitle2  }, 
				function(returnedData){
					if(returnedData === "Exists") {
						filenameurl = "downloads/" + vidtitle2
						$("#viddown").hide();
						$("#vidcanc").hide();
						$("#downloadbar").hide();
						$("#vidlink").attr("href", filenameurl);
						$("#vidlink").show();
						$("#vidrestart").show();
						$("#downloadready").attr("style", "display: inline; padding: 5px");
						clearInterval(checkIntervalId);
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

	function clearElements() { 
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
