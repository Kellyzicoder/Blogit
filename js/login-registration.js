//const container = document.querySelector(".container"),
 const pwShowHide = document.querySelectorAll(".showHidePw"),
 pwFields = document.querySelectorAll(".password");
//  signup = document.querySelector(".signup-link"),
//  login = document.querySelector(".login-link"),
//signupform = document.getElementById("signup");

// js code to show/hide password and change icon
pwShowHide.forEach(eyeIcon => {
  eyeIcon.addEventListener("click", () => {
    pwFields.forEach(pwFields => {
      if (pwFields.type === "password") {
        pwFields.type = "text";

        pwShowHide.forEach(icon => {
          icon.classList.replace("uil-eye-slash", "uil-eye");
        })
      } else {
        pwFields.type = "password";

        pwShowHide.forEach(icon => {
          icon.classList.replace("uil-eye", "uil-eye-slash");
        })
      }
    })
  })
})


//function removeIfExists (selector) {
//	var x = document.querySelector(selector)
//	if(x) x.remove()
//}

//js code to appear signup and login form
//signup.addEventListener("click", () => {
//  container.classList.add("active");
//});
//login.addEventListener("click", () => {
//	removeIfExists(".passworderror");
//	signupform.reset();
//	
////	signupform.getElementById("username").value = "";
//  container.classList.remove("active");
//})
