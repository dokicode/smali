;(function(){

	var ns = this;

	function validate(url){
		var pattern = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        return pattern.test(url);
	}

	ns.generateLink = function(ans){
		if(ans['success']) {
			//document.getElementById('short_link').innerHTML = ans['short_link'];
			document.getElementById('short_link').innerHTML = ans['html'];
		}else{
			alert('Error:' + ans['error']);
		}
		btnGenerate.disabled = false;  
	}


	ns.getLinks = function(ans){
        document.getElementById('links').innerHTML = ans['html'];
        updateDelEvent();
	}


	ns.deleteItem = function (ans){
		var itemId = ans['itemId'];
		var trDel = document.getElementById('tr-' + itemId);
		trDel.remove();
	}	

	function sendAjax(ajaxObj){

		var json = JSON.stringify(ajaxObj);

		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'ajax.php');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send('json=' + json);

		xhr.onreadystatechange = function(){
            if(xhr.readyState != 4) return;
            
            if(xhr.status != 200) {
                alert( '200: ' + xhr.status + ' : ' + xhr.statusText );
            } else {

                var response = xhr.responseText;
                var ans = JSON.parse(response);
                ns[ajaxObj['action']](ans);         
            }
        }
	}




	var btnGenerate = document.getElementById("btnGenerate");
	btnGenerate.addEventListener("click", function(){
		var link = document.getElementById("link").value;
		if(validate(link)){
			var ajaxObj = {
	            'action': "generateLink",
	            'link': encodeURIComponent(link)
	        };
        	btnGenerate.disabled = true;
			sendAjax(ajaxObj);
		}else{
			alert('Link has wrong format');
		}

	});


	var btnShowLinks = document.getElementById("btnShowLinks");
	btnShowLinks.addEventListener("click", function(){

			var ajaxObj = {
	            'action': "getLinks"
	        };
			sendAjax(ajaxObj);
	});

	function updateDelEvent() {
		var btnDel = document.querySelectorAll(".del");
		for(var i=0; i<btnDel.length; i++){
			btnDel[i].addEventListener("click", function(){
				var ajaxObj = {
		            'action': "deleteItem",
		            'itemId': this.getAttribute('data-item')
		        };
				sendAjax(ajaxObj);
			});
		}
	}



})();