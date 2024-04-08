let searchBox = document.getElementById('searchBox');
let suggestionsBox = document.getElementById('suggestions');
let listItems = document.getElementsByClassName('list');
console.info(listItems);

searchBox.addEventListener('input', (e) => {
    let query = e.target.value;
    console.info(query);
    let type = e.target.getAttribute('data-next');
    let lastTerm = extractLast(query);
    console.info(query);
    console.info(lastTerm);
    console.info(type);
    if (lastTerm.length < 2) return;
    let action = `get_${type}`;
    
    // Make AJAX request
    fetch(ajaxObject.ajaxUrl,{
        method: 'POST',
        headers: { 'Content-type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams({
            action: action
      })
    })
  .then(response => response.json())
  .then(data => {
      console.info(data);
      // Clear old suggestions
      suggestionsBox.innerHTML = '';
      //Initially remove all elements (so if user erases a letter or adds new letter then clean previous outputs)
      removeElements();
      // Create new suggestions
      Object.keys( data ).forEach( key => {
        let item = data[key];
        console.info( item );
        
        if(item.toLowerCase().startsWith(searchBox.value.toLowerCase()) && searchBox.value != '' ) {
          let listItem = document.createElement("li");
            listItem.classList.add("list-items");
            listItem.style.cursor = "pointer";
            listItem.addEventListener('click', function() {
              searchBox.value = item;
            });            
          let word ="<b>" + item.substr(0, searchBox.value.length) + "</b>";
            word+= item.substr(searchBox.value.length);
          listItem.innerHTML = word;
          suggestionsBox.appendChild(listItem);
        }
        //convert input to lower case

        /* let div = document.createElement('div');
        div.textContent = item;
        div.classList.add('suggestion');
        div.addEventListener('click', function() {
          let terms = split(searchBox.value);
          terms.pop();
          terms.push(item);
          terms.push("");
          searchBox.value = terms.join(", ");
          suggestionsBox.innerHTML = ''; // clear suggestions after selection
        });
        suggestionsBox.appendChild(div); */
      });
      let nextAction = '';
      switch( action ) {
        case "provincia": nextAction = 'municipio';
        case "municipio" : nextAction = 'calle';
        case "calle" : nextAction = 'numero';
      }
      e.target.setAttribute( 'data-next', nextAction );
    })
    .catch(error => console.error('Error fetching data:', error));
});


function split(val) {
  return val.split(/,\s*/);
}

function extractLast(term) {
  return split(term).pop();
}

function displayNames(value) {
  document.getElementById('searchBox').value = value;
}
function removeElements() {
  let items = document.querySelectorAll(".list-items");
  items.forEach((item) => {
    item.remove();
  });
}