const hamBurger = document.querySelector('.toggle-btn');

hamBurger.addEventListener('click', function () {
  document.querySelector('#sidebar').classList.toggle('expand');
});

// Function to remove URL parameters
function removeURLParameter(param) {
  var url = window.location.href;
  var regex = new RegExp('[\\?&]' + param + '=([^&#]*)');
  var results = regex.exec(url);
  if (results !== null) {
    var newUrl = url.replace(results[0], '');
    history.replaceState(null, null, newUrl);
  }
}

// Remove the 'status' parameter after displaying the message
window.onload = function () {
  removeURLParameter('status');
};
