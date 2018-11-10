;(function(){
	//alert('hallo');
	var ns = this;

	function validate(url){
		var pattern = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if (pattern.test(url)) {
            //alert("Url is valid");
            return true;
        }else{
        	//alert("Url is wrong");
        	return false;
        }
	}

	ns.generateLink = function(ans){
		if(ans['status']) {
			document.getElementById('short_link').innerHTML = ans['short_link'];
		}else{
			alert(ans['error']);
		}
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
	}

	function sendAjax(ajaxObj){

/*
		var ajaxObj = {
            'action': "generateLink",
            'link': link
        };
*/
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
            	//json.action();
            	
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
			sendAjax(ajaxObj);
		}else{
			alert('Link is wrong');
		}
		//alert('link:' + link);

	});


	var btnShowLinks = document.getElementById("btnShowLinks");
	btnShowLinks.addEventListener("click", function(){

			var ajaxObj = {
	            'action': "getLinks"
	        };
			sendAjax(ajaxObj);

		//alert('link:' + link);

	})
})();