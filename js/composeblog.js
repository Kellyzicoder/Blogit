//This is for the modal
var modal = document.querySelector(".bg-modal");
var blogadd = document.querySelector(".composeblog");
var close = document.querySelector(".cancelnewblog");


blogadd.addEventListener('click' , () => {
	modal.classList.remove("no-modal");
})

close.addEventListener('click' , () => {
	modal.classList.add("no-modal");
})