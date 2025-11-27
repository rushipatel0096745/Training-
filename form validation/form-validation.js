function submitHandler(event) {
  event.preventDefault();
  const form = document.querySelectorAll("form");
  const displayError = document.querySelector(".errors");
  console.log(form);
  console.log(form[0]);
  console.log(form[0].length);

  let requiredFields = document.querySelectorAll(".required");
  console.log(requiredFields);
  console.log(requiredFields.length);

  displayError.textContent = "";

  let errors = [];
  for (let i = 0; i < requiredFields.length; i++) {
    // console.log(requiredFields[i]);

    // type email
    const emailRegex = /^([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})$/;
    if (requiredFields[i].type == "email") {
      if (requiredFields[i].value === "") {
        errors.push("Email is required");
      } else if (!emailRegex.test(requiredFields[i].value)) {
        errors.push("Email is invalid");
      }
    }

    // type text
    if (requiredFields[i].type == "text") {
      if (requiredFields[i].value === "") {
        errors.push(`${requiredFields[i].name} is required`);
      }
    }

    // type date
    if (requiredFields[i].type == "date") {
      if (requiredFields[i].value === "") {
        errors.push(`${requiredFields[i].name} is required`);
      }
    }

    // type tel
    const mobRegex = /^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$/;
    if (requiredFields[i].type == "tel") {
      if (requiredFields[i].value === "") {
        errors.push(`${requiredFields[i].name} is required`);
      } else if (!mobRegex.test(requiredFields[i].value)) {
        errors.push(`${requiredFields[i].name} is required`);
      }
    }

    // type radio
    if (requiredFields[i].type == "radio") {
      const totalRadios = document.querySelectorAll(
        'input.required[type="radio"]'
      );
      let isChecked = false;

      for (let i = 0; i < totalRadios.length; i++) {
        if (totalRadios[i].checked) {
          isChecked = true;
        }
      }

      if (!isChecked) {
        errors.push(`${requiredFields[i].name} is required`);
      }
    }

    console.log((requiredFields[i].type = "radio"));
  }

  console.log("errors....", errors);
  console.log("errors....", errors.length);

  if (errors.length === 0) {
    displayError.innerHTML = "";
  } else {
    for (let i = 0; i < errors.length; i++) {
      displayError.innerHTML += `<ul>
          <li>${errors[i]}</li>
        </ul>`;
    }
  }
}
