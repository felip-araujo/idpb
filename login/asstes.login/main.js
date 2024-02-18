function togglePasswordVisibility() {
    const senhaInput = document.getElementById("senha");
    const senhaIcon = document.querySelector(".senha-icon");

    if (senhaInput.type === "password") {
      senhaInput.type = "text";
      senhaIcon.classList.remove('fa-eye-slash');
      senhaIcon.classList.add('fa-eye');
    } else {
      senhaInput.type = "password";
      senhaIcon.classList.remove('fa-eye');
      senhaIcon.classList.add('fa-eye-slash');
    }
  }