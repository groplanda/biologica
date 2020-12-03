const Confirm = () => {

  const removeConfirm = (checkboxSelector, btnSelector) => {
    const checkbox = document.querySelector(checkboxSelector),
          btn = document.querySelector(btnSelector);
    if(checkbox !== null & btn !== null) {
      checkbox.addEventListener('change', (e) => {
        if(e.target.checked) {
          btn.removeAttribute('disabled');
        } else {
          btn.setAttribute('disabled', 'disabled');
        }
      })
    }
  }

  removeConfirm('#privacy-policy-rewiews', '.rewiews__form button.button');
  removeConfirm('#privacy-policy-consultation', '.form button.button');
  removeConfirm('#privacy-policy-consultation-modal', '.popup button.button');

}
export default Confirm;