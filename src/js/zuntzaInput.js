let searchBox = document.getElementById('searchBox');
let suggestionsBox = document.getElementById('suggestions');

document.querySelector('[data-action="reset"]').addEventListener('click', (event) =>{
    searchBox.value='';
});
// On document load we will render the "provincias" elements returned via ajax and put them into suggestionsBox
document.addEventListener('DOMContentLoaded', async () => {
    // Set the value of searchBox to an empty string
    searchBox.value = "";
    try {
        await renderData("provincia");
    } catch(error) {
        console.error(`Error: ${error}`);
    }
    searchBox.addEventListener('input', (event) => {
        console.info(searchBox.value);
        console.info(event.target.value);
    })
});

async function renderData(action="provincia", itemName='') {
    // we get a json object with the expected data numerically indexed 
    let items = await loadData(action, itemName);
    suggestionsBox.innerHTML = '';
    Object.keys( items ).forEach( key => {
        let item = items[key];
        let listItem = addToList(item);
        suggestionsBox.append(listItem);
    });
}

async function loadData( action = "provincia", itemName='' ) {
    document.getElementById("loading-icon").style.display = "block";
    suggestionsBox.innerHTML = "";
    try { 
        let response = await fetch(ajaxObject.ajaxUrl,{
            method: 'POST',
            headers: { 'Content-type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                action: `get_${action}`,
                query: itemName
            }),
        });
        if (action == 'final'){ 
            let text = await response.text();
            text = text.slice(0,-1);
            console.info(text);
            document.querySelector("#greeting").textContent = text;
            return;
            //return text;
        } else {
            return await response.json();
        }
    } catch(error) {
        console.error("An error occurred:", error);
    } finally {
        // Hide loading icon
        document.getElementById("loading-icon").style.display = "none";
    }
}

function addToList(item){
    let listItem = document.createElement("div");
    let action = searchBox.getAttribute('data-next');
    let value = searchBox.value;
    listItem.classList.add("list-items");
    listItem.style.cursor = "pointer";
    listItem.innerHTML = item;  // Set the content of listItem to item
    listItem.addEventListener('click', ( event ) => {
        let clickedItemValue = event.target.textContent;
        searchBox.value = (value== '')? item : `${value}, ${item}`;
        let types = {
            'provincia' : 'municipio',
            'municipio' : 'calle',
            'calle' : 'numero',
            'numero':'final',
        };
        searchBox.setAttribute('data-next', types[action]);
        renderData( types[action], clickedItemValue );
    });
    return listItem;
    
}



function addToInput(item){
    
}