document.addEventListener('DOMContentLoaded', function () {
  // Toggle between sign-in and sign-up forms
  const toggleSignin = document.getElementById('toggleSignin');
  const toggleSignup = document.getElementById('toggleSignup');
  const signInForm = document.getElementById('signInForm');
  const signUpForm = document.getElementById('signUpForm');

  if (toggleSignin && toggleSignup && signInForm && signUpForm) {
    // Ensure all elements are present before attaching event listeners

    toggleSignin.addEventListener('click', function () {
      signInForm.classList.add('active');
      signUpForm.classList.remove('active');
    });

    toggleSignup.addEventListener('click', function () {
      signUpForm.classList.add('active');
      signInForm.classList.remove('active');
    });
  } else {
    console.error('One or more elements not found. Check your HTML markup and IDs.');
  }
});
