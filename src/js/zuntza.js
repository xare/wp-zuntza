document.addEventListener('DOMContentLoaded', (event) => {
    // Populate provincia dropdown
    fetch(ajaxObject.ajaxUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'get_provincia'
        })
    })
    .then(response => response.json())
    .then(data => {
        console.info(data);
        let provincia = document.querySelector("#provincia");
        Object.keys(data).map(function(key) {
            let option = document.createElement("option");
            option.text = data[key];
            option.value = key;
            provincia.add(option);
        });
        provincia.style.display = "block";
    });

    // Populate municipio dropdown when a provincia is selected
    document.querySelector("#provincia").addEventListener('change', function() {
        let provinciaIndex = this.value;
        fetch(ajaxObject.ajaxUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'get_municipio',
                provinciaIndex: provinciaIndex
            })
        })
        .then(response => response.json())
        .then(data => {
            let municipio = document.querySelector("#municipio");
            municipio.innerHTML = '';
            Object.keys(data).map(function(key) {
                let option = document.createElement("option");
                option.text = data[key];
                option.value = key;
                municipio.add(option);
            });
            municipio.style.display = "block";
        });
    });

    // Populate calle dropdown when a municipio is selected
    document.querySelector("#municipio").addEventListener('change', function() {
        let provinciaIndex = document.querySelector("#provincia").value;
        let municipioIndex = this.value;
        fetch(ajaxObject.ajaxUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'get_calle',
                provinciaIndex: provinciaIndex,
                municipioIndex: municipioIndex
            })
        })
        .then(response => response.json())
        .then(data => {
            let calle = document.querySelector("#calle");
            calle.innerHTML = '';
            Object.keys(data).map(function(key) {
                let option = document.createElement("option");
                option.text = data[key];
                option.value = key;
                calle.add(option);
            });
            calle.style.display = "block";
        });
    });
    document.querySelector('#calle').addEventListener('change', function() {
        let provinciaIndex = document.querySelector("#provincia").value;
        let municipioIndex = document.querySelector("#municipio").value;
        let calleIndex = document.querySelector("#calle").value;
        let numeroIndex = this.value;
        fetch(ajaxObject.ajaxUrl, {
            method: 'POST',
            headers: { 'Content-type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                    action: 'get_numero',
                    provinciaIndex: provinciaIndex,
                    municipioIndex: municipioIndex,
                    calleIndex: calleIndex,
                    numeroIndex: numeroIndex
                })
            })
        .then(response => response.json())
        .then(data => {
            let numero = document.querySelector("#numero");
            numero.innerHTML = '';
            Object.keys(data).map(function(key) {
                let option = document.createElement("option");
                option.text = data[key];
                option.value = key;
                numero.add(option);
            });
            numero.style.display = "block";
        });
    });
    // Display a sentence underneath the selects when a calle is selected
    document.querySelector("#numero").addEventListener('change', function() {
        if (this.value) {
            document.querySelector("#greeting").textContent = "Zuk hautatutako helbidean badago zuntza jadanik.";
        } else {
            document.querySelector("#greeting").textContent = "";
        }
    });
});
