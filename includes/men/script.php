<script type="text/javascript">
	document.querySelector('#right-arrow').addEventListener('click', e=>{
		let slide = document.querySelector('#slide');
		slide.style.transform = "translateX(-50%)";

		let leftBtn = document.querySelector('#left-arrow button');
		leftBtn.classList.remove('disabled');
		leftBtn.classList.add('deep-grey-text');
		leftBtn.removeAttribute('disabled');

		let rightBtn = document.querySelector('#right-arrow button');
		rightBtn.classList.remove('deep-grey-text');
		rightBtn.classList.add('disabled');
		rightBtn.setAttribute('disabled', true);
	});

	document.querySelector('#left-arrow').addEventListener('click', e=>{
		let slide = document.querySelector('#slide');
		slide.style.transform = "translateX(0%)";

		let rightBtn = document.querySelector('#right-arrow button');
		rightBtn.classList.remove('disabled');
		rightBtn.classList.add('deep-grey-text');
		rightBtn.removeAttribute('disabled');

		let leftBtn = document.querySelector('#left-arrow button');
		leftBtn.classList.remove('deep-grey-text');
		leftBtn.classList.add('disabled');
		leftBtn.setAttribute('disabled', true);
	});
</script>