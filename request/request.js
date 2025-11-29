document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("requestForm");

    form.addEventListener("submit", function(e) {
        e.preventDefault(); // prevent redirect to PHP

        let formData = new FormData(form);

        let name = formData.get("client_name").trim();
        let email = formData.get("client_email").trim();
        let service = formData.get("service_type");
        let message = formData.get("message").trim();

        // VALIDATION
        if (!name || !email || !service || !message) {
            alert("Please fill all fields.");
            return;
        }

        if (!email.includes("@")) {
            alert("Please enter a valid email.");
            return;
        }

        // SEND TO PHP
        fetch("request.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            console.log(data);  // ← to check PHP response
            alert("Your request has been submitted!");
            window.location.href = "../home/home.php";
        })
        .catch(err => {
            console.error(err);
            alert("Error submitting request.");
        });
    });

});