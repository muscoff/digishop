<script type="text/javascript">

	function cartNo() {
		fetch('<?=url_location;?>cart.php?total')
		.then(response=>response.json())
		.then(data=>{
			document.querySelector('#cart').innerHTML = data.total;
		})
		.catch(error=>console.log(error));
		setTimeout(cartNo, 2000);
	}

	cartNo();

	function banner() {
		let ban = document.querySelectorAll('.banner img');
		let length = ban.length;

		let banContainer = document.querySelectorAll('.banner');

		for(let i=0; i<length; i++){
			ban[i].style.display = "none";
			let attr = ban[i].getAttribute('src');
			banContainer[i].style.backgroundImage = "url("+attr+")";
			//banContainer[i].style.backgroundAttachment = "fixed";
			banContainer[i].style.backgroundPosition = "center center";
			banContainer[i].style.backgroundSize = "cover";
		}
	}

	banner();

	window.addEventListener('scroll', e=>{
		let fixed = document.querySelector('#fixed');
		let scrolled = window.pageYOffset;

		if(scrolled>=36){
			fixed.classList.add('fixed');
			fixed.classList.add('top-0');
		}
		else{
			fixed.classList.remove('fixed');
			fixed.classList.remove('top-0');
		}
	});

	document.querySelector('#subscribe').addEventListener('keypress', e=>{
		if(e.keyCode == 13){
			alert('yes!');
		}
	});

	document.querySelector('#search').addEventListener('keypress', e=>{
		let search = document.querySelector('#search').value;
		if(e.keyCode == 13){
			window.location = "product.php?search="+search;
		}
	});

</script>