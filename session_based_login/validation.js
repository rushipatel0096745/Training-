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
    
    const submittedForm = event.target;
    console.log(submittedForm);
  
    let requiredFields = submittedForm.querySelectorAll(".required");
    const radioNameSets = new Set();
    const checkBoxesSet = new Set();
    let flag = false;
  

    for (let i = 0; i < requiredFields.length; i++) {
      // type email
      const emailRegex = /^([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,})$/;
      if (requiredFields[i].type == "email") {
        const nextEle = requiredFields[i].nextElementSibling;
        console.log(nextEle);
  
        if (requiredFields[i].value === "") {
          if (nextEle) {
            nextEle.textContent = "email is required";
            flag = false
          }
        } else if (!emailRegex.test(requiredFields[i].value)) {
          if (nextEle) {
            nextEle.textContent = "email is invalid";
            flag = false

          }
        } else {
          nextEle.textContent = "";
          flag = true
        }
      }
  
      // type text
      if (requiredFields[i].type == "text") {
        const nextEle = requiredFields[i].nextElementSibling;
        console.log(nextEle);
  
        if (requiredFields[i].value === "") {
          nextEle.textContent = `${requiredFields[i].name} is required`;
          flag = false

        } else {
          nextEle.textContent = "";
          flag = true
        }
      }

      // type password
      if (requiredFields[i].type == "password") {
        const nextEle = requiredFields[i].nextElementSibling;
        console.log(nextEle);
  
        if (requiredFields[i].value === "") {
          nextEle.textContent = `${requiredFields[i].name} is required`;
          flag = false

        } else {
          nextEle.textContent = "";
          flag = true
        }
      }
  
      // type date
      if (requiredFields[i].type == "date") {
        const nextEle = requiredFields[i].nextElementSibling;
        console.log(nextEle);
  
        if (requiredFields[i].value === "") {
          nextEle.textContent = `${requiredFields[i].name} is required`;
        }
        else {
          nextEle.textContent = "";
        }
      }
  
      // type tel
      const mobRegex = /^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$/;
      if (requiredFields[i].type == "tel") {
        const nextEle = requiredFields[i].nextElementSibling;
        console.log(nextEle);
        if (requiredFields[i].value === "") {
          nextEle.textContent = `${requiredFields[i].name} is required`;
          flag = false
        } else if (!mobRegex.test(requiredFields[i].value)) {
          nextEle.textContent = `${requiredFields[i].name} is invalid`;
          flag = false
        }
        else {
          nextEle.textContent = "";
          flag = true
        }
      }
  
      // for selection
      if (requiredFields[i].tagName == "SELECT") {
      
        const nextEle = requiredFields[i].nextElementSibling;
  
        if (requiredFields[i].value === "") {
        
          nextEle.textContent = `select one of the option for ${requiredFields[i].name}`;
        } else {
          nextEle.textContent = "";
        }
       
      }
  
      // type radio
      if (requiredFields[i].type === "radio") {
        
        const nextEle = findNextEle(requiredFields[i]);
  
        const totalRadios = submittedForm.querySelectorAll(
          'input.required[type="radio"]'
        );
  
        for (let i = 0; i < totalRadios.length; i++) {
          if (radioNameSets.has(totalRadios[i].name)) {
            continue;
          }
          
          radioNameSets.add(totalRadios[i].name);
        
          let tempRadio = submittedForm.querySelectorAll(`input.required[name=${totalRadios[i].name}]`)
          console.log(tempRadio);
          let isChecked = false;
          for (let i = 0; i < tempRadio.length; i++) {
            if (tempRadio[i].checked) {
              isChecked = true;
              break;
            }
          }
          if (!isChecked) {
            
            nextEle.textContent = `select the ${totalRadios[i].name}`;
          } else {
            nextEle.textContent = "";
          }
        } //end of inner loop
      }
      console.log("outer i", i);
      
      // for checkboxes
      if (requiredFields[i].type === "checkbox") {
        const nextEle = findNextEle(requiredFields[i]);
        console.log(nextEle);
  
        let totalCheckboxes = submittedForm.querySelectorAll(
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
  
          let tempCheckboxes = submittedForm.querySelectorAll(
            `input.required[name="${totalCheckboxes[i].name}"]`
          );
          console.log("temp checkboxes", tempCheckboxes);
          console.log("temp checkboxes", tempCheckboxes.length);
  
    
          if (!Array.from(tempCheckboxes).some((item) => item.checked)) {
            console.log("pushing error");
            nextEle.textContent = `please select the ${tempCheckboxes[i].name}`;
          } else {
            nextEle.textContent = "";
          }
        }
      }
  
      // for number
      if (requiredFields[i].type == "number") {
        const nextEle = requiredFields[i].nextElementSibling;
        
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
      }
    } //end of for loop

    if(flag == true){
      return true
    }
    else {
      return false
    }
  
   
  }
  