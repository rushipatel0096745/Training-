function findNextEle(startElement) {
  let current = startElement.nextElementSibling;

  while (current) {
    if (current.tagName == "DIV") {
      return current;
    }
    current = current.nextElementSibling;
  }
  return null;
}

function getCharCounter(event, ele) {
  event.preventDefault();
  const text = ele.value;
  // const counterEle = document.getElementById("counter")
  // counterEle.textContent = `Character count is ${text.length}`
  const nextEle = ele.nextElementSibling;
  nextEle.textContent = `Character count is ${text.length}`;
}

function submitHandler(event) {
  event.preventDefault();
  const submittedForm = event.target;
  console.log(submittedForm);

  let requiredFields = submittedForm.querySelectorAll(".required");
  const radioNameSets = new Set();
  const checkBoxesSet = new Set();

  // let errors = [];

  for (let i = 0; i < requiredFields.length; i++) {
    // type email
    const emailRegex = /^([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})$/;
    if (requiredFields[i].type == "email") {
      const nextEle = requiredFields[i].nextElementSibling;
      console.log(nextEle);

      if (requiredFields[i].value === "") {
        if (nextEle) {
          nextEle.textContent = "email is required";
        }
      } else if (!emailRegex.test(requiredFields[i].value)) {
        // errors.push("Email is invalid");
        if (nextEle) {
          nextEle.textContent = "email is invalid";
        }
      } else {
        nextEle.textContent = "";
      }
    }

    // type text
    if (requiredFields[i].type == "text") {
      const nextEle = requiredFields[i].nextElementSibling;
      console.log(nextEle);

      if (requiredFields[i].value === "") {
        // errors.push(`${requiredFields[i].name} is required`);
        // displayError.innerHTML = `${requiredFields[i].name} is required`
        // para.textContent = `${requiredFields[i].name} is required`
        nextEle.textContent = `${requiredFields[i].name} is required`;
      } else {
        nextEle.textContent = "";
      }
    }

    // type date
    if (requiredFields[i].type == "date") {
      // const para = document.createElement('p')
      const nextEle = requiredFields[i].nextElementSibling;
      console.log(nextEle);

      if (requiredFields[i].value === "") {
        // errors.push(`${requiredFields[i].name} is required`);
        // displayError.innerHTML = `${requiredFields[i].name} is required`
        nextEle.textContent = `${requiredFields[i].name} is required`;
      }
      // requiredFields[i].insertAdjacentElement("afterend", para)
      else {
        nextEle.textContent = "";
      }
    }

    // type tel
    const mobRegex = /^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$/;
    if (requiredFields[i].type == "tel") {
      const nextEle = requiredFields[i].nextElementSibling;
      console.log(nextEle);
      // const para = document.createElement('p')
      if (requiredFields[i].value === "") {
        // errors.push(`${requiredFields[i].name} is required`);
        // displayError.innerHTML = `${requiredFields[i].name} is required`
        nextEle.textContent = `${requiredFields[i].name} is required`;
      } else if (!mobRegex.test(requiredFields[i].value)) {
        // errors.push(`${requiredFields[i].name} is required`);
        nextEle.textContent = `${requiredFields[i].name} is invalid`;
      }
      // requiredFields[i].insertAdjacentElement("afterend", para)
      else {
        nextEle.textContent = "";
      }
    }

    // for selection
    if (requiredFields[i].tagName == "SELECT") {
      // const para = document.createElement('p')
      const nextEle = requiredFields[i].nextElementSibling;

      if (requiredFields[i].value === "") {
        // errors.push(`select one of the option for ${requiredFields[i].name}`);
        nextEle.textContent = `select one of the option for ${requiredFields[i].name}`;
      } else {
        nextEle.textContent = "";
      }
      // requiredFields[i].insertAdjacentElement("afterend", para)
    }

    // type radio
    if (requiredFields[i].type === "radio") {
      // const nextEle = requiredFields[i].nextElementSibling
      const nextEle = findNextEle(requiredFields[i]);

      const totalRadios = document.querySelectorAll(
        'input.required[type="radio"]'
      );

      for (let i = 0; i < totalRadios.length; i++) {
        if (radioNameSets.has(totalRadios[i].name)) {
          continue;
        }
        // console.log("iter", i);
        radioNameSets.add(totalRadios[i].name);
        let tempRadio = document.getElementsByName(totalRadios[i].name);
        // console.log(tempRadio);
        let isChecked = false;
        for (let i = 0; i < tempRadio.length; i++) {
          if (tempRadio[i].checked) {
            isChecked = true;
            break;
          }
        }
        // console.log(radioNameSets);
        if (!isChecked) {
          // errors.push(`select the ${totalRadios[i].name}`);
          nextEle.textContent = `select the ${totalRadios[i].name}`;
        } else {
          nextEle.textContent = "";
        }
      } //end of inner loop
      // requiredFields[i].insertAdjacentElement("afterend", para)
    }
    console.log("outer i", i);
    // for checkboxes
    if (requiredFields[i].type === "checkbox") {
      const nextEle = findNextEle(requiredFields[i]);
      console.log(nextEle);

      let totalCheckboxes = document.querySelectorAll(
        'input.required[type="checkbox"]'
      );

      console.log("total checkboxes", totalCheckboxes);
      console.log("total checkboxes", totalCheckboxes.length);

      for (let i = 0; i < totalCheckboxes.length; i++) {
        _name = totalCheckboxes[i].name;
        console.log("name", _name);
        if (checkBoxesSet.has(totalCheckboxes[i].name)) {
          console.log("skipping this time");
          continue;
        }
        console.log("iteration", i);

        console.log(checkBoxesSet.add(totalCheckboxes[i].name));

        let tempCheckboxes = document.getElementsByName(
          totalCheckboxes[i].name
        );
        console.log("temp checkboxes", tempCheckboxes);
        console.log("temp checkboxes", tempCheckboxes.length);

        // console.log(Array.from(tempCheckboxes).some((item) => item.checked));

        // for (let i = 0; i < tempCheckboxes.length; i++) {
        //   let notSelected = 0
        //   if(!tempCheckboxes[i].checked){
        //     notSelected += 1
        //   }
          
        // }

        if (!Array.from(tempCheckboxes).some((item) => item.checked)) {
          console.log("pushing error");
          // errors.push(`please select the ${totalCheckboxes[i].name}`);
          nextEle.textContent = `please select the ${tempCheckboxes[i].name}`;
        } else {
          nextEle.textContent = "";
        }
      }
      // requiredFields[i].insertAdjacentElement("afterend", para)
    }

    // for number
    if (requiredFields[i].type == "number") {
      const nextEle = requiredFields[i].nextElementSibling;
      // console.log(nextEle);

      if (requiredFields[i].value === "") {
        nextEle.textContent = `${requiredFields[i].name} is required`;
      } else {
        nextEle.textContent = "";
      }
    }

    // for textarea
    if (requiredFields[i].tagName == "TEXTAREA") {
      const nextEle = findNextEle(requiredFields[i]);

      const text = requiredFields[i].value.trim();

      const maxAttr = requiredFields[i].getAttribute("max");

      if (requiredFields[i].value === "") {
        nextEle.textContent = `${requiredFields[i].name} is required`;
      } else if (maxAttr) {
        if (text.length > maxAttr) {
          nextEle.textContent = `no more than ${maxAttr} characters are allowed`;
        } else {
          nextEle.textContent = "";
        }
      } else {
        nextEle.textContent = "";
      }

      // requiredFields[i].addEventListener("keyup", () => {
      //   const text = requiredFields[i].value.trim();
      //   console.log(` Character count: ${text.length}`);
      //   nextEle.innerHTML = `<span style="color: black">
      //   Character count: ${text.length}
      //   </span>`;

      // });
    }
  } //end of for loop

  // console.log("errors....", errors);
  // console.log("errors....", errors.length);
}
