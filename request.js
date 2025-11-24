document.addEventListener("DOMContentLoaded", () => {

  const form = document.getElementById("auditForm");

  form.addEventListener("submit", (e) => {
    const inputs = form.querySelectorAll("input, textarea");
    let valid = true;

    inputs.forEach((inp) => {
      if (inp.value.trim() === "") {
        valid = false;
        inp.style.borderColor = "#ef4444";
      } else {
        inp.style.borderColor = "#22c55e";
      }
    });

    if (!valid) {
      e.preventDefault();
      alert("Please fill all fields before submitting.");
    }
  });

});