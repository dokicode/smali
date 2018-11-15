;(function(){

	var ns = this;

	function validate(url){
		var pattern = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        return pattern.test(url);
	}

	ns.generateLink = function(ans){
		if(ans['status']) {
			//document.getElementById('short_link').innerHTML = ans['short_link'];
			document.getElementById('short_link').innerHTML = ans['html'];
		}else{
			alert(ans['error']);
		}
		btnGenerate.disabled = false;
		//alert(ans['status']);
        //alert(ans['server_response']);
        //alert(ans['url_hash']);
        
	}


	ns.getLinks = function(ans){
		//alert(ans['status']);
		//alert(ans['html']);
        //alert(ans['server_response']);
        //alert(ans['url_hash']);
        document.getElementById('links').innerHTML = ans['html'];
        updateDelEvent();
	}


	ns.deleteItem = function (ans){
		var itemId = ans['itemId'];
		//console.log('itemId:' + itemId);
		var trDel = document.getElementById('tr-' + itemId);
		trDel.remove();
	}	

	function sendAjax(ajaxObj){

		var json = JSON.stringify(ajaxObj);

        //alert(ajaxObj['action']);
        
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'ajax.php');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		//xhr.setRequestHeader('Content-Type', 'application/json');
		//xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
		xhr.send('json=' + json);

		xhr.onreadystatechange = function(){
            if(xhr.readyState != 4) return;
            
            if(xhr.status != 200) {
                alert( '200: ' + xhr.status + ' : ' + xhr.statusText );
            } else {
                //alert(xhr.getAllResponseHeaders());//return headers
                //alert( xhr.responseText);
                var response = xhr.responseText;
                //alert(response);
                var ans = JSON.parse(response);
                ns[ajaxObj['action']](ans);
 
                
            }
        }
       

	}




	var btnGenerate = document.getElementById("btnGenerate");
	btnGenerate.addEventListener("click", function(){
		var link = document.getElementById("link").value;
		if(validate(link)){
			//alert("Url is valid");
		var ajaxObj = {
            'action': "generateLink",
            'link': encodeURIComponent(link)
        };
        	btnGenerate.disabled = true;
			sendAjax(ajaxObj);
		}else{
			alert('Link has wrong format');
		}
		//alert('link:' + link);

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