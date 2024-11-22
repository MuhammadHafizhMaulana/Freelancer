var prevNomor = "";
var nomorValid = false;
var passwordField = document.getElementById('password');
var nomorField = document.getElementById('nomor');
var passwordAlert = document.getElementById('passwordAlert');

const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/;
const nomorPattern = /^[0-9]+$/;
var fieldStatus = false;
var passwordStatus = false

passwordField.addEventListener('input', function () {
    if(document.getElementById('formRegistrasi')) {
        if (passwordPattern.test(passwordField.value)) {
            passwordStatus = true
            passwordAlert.innerText = ""
        } else {
            passwordStatus = false
            passwordAlert.innerText = "Password harus berisi minimal 8 karakter dan mengandung huruf kapital, huruf kecil, dan angka"
        }
    }

    checkSubmitValid();
});

nomorField.addEventListener('input', function () {
    if (this.value === "") {
        prevNomor = "";
    } else if (nomorPattern.test(this.value)) {
        prevNomor = this.value;
    } else {
        this.value = prevNomor;
    }

    if (this.value.length >= 10 && this.value.startsWith("08")) {
        nomorValid = true;
    } else {
        nomorValid = false;
    }

    if (document.getElementById('nomorAlert')) {
        const nomorAlert = document.getElementById('nomorAlert')

        if (!nomorValid) {
            nomorAlert.innerHTML = "Nomor harus diawali '08' dan memiliki lebih dari 9 karakter";
        } else {
            nomorAlert.innerHTML = '';
        }
    }

    checkSubmitValid();
})

function checkSubmitValid() {
    if (document.getElementById('formRegistrasi')) {
        if (fieldStatus && passwordStatus && nomorValid) {
            document.getElementById('submitButton').disabled = false;
        } else {
            document.getElementById('submitButton').disabled = true;
        }
    } 
    if (document.getElementById('formLogin')) {
        if (fieldStatus) {
            document.getElementById('submitButton').disabled = false;
        } else {
            document.getElementById('submitButton').disabled = true;
        }
    }
}

function formValid() {
    fieldStatus = true;
    const value = document.getElementsByClassName("registrasi-form");
    for (let index = 0; index < value.length; index++) {
        if (value[index].value === "") { // Jika ada yang kosong
            fieldStatus = false; // Mengubah nilai menjadi false
            break; // Hentikan iterasi
        }
    }

    checkSubmitValid();
}

// Panggil formValid saat halaman dimuat
window.addEventListener('DOMContentLoaded', () => {
    formValid(); // Memanggil formValid saat halaman dimuat

    // Event listener untuk input fields lainnya
    const inputFields = document.querySelectorAll('.registrasi-form');
    inputFields.forEach(input => {
        input.addEventListener('input', formValid); // Panggil formValid setiap kali ada input berubah
    });
});

function openSpinner() {
    // Ambil elemen body dari dokumen
    var body = document.getElementsByTagName("body")[0];

    // Buat elemen div untuk spinner
    var spinnerDiv = document.createElement("div");
    spinnerDiv.className = "spinner-opened";

    // Buat elemen div untuk spinner-border
    var spinnerBorderDiv = document.createElement("div");
    spinnerBorderDiv.className = "spinner-border text-light";
    spinnerBorderDiv.setAttribute("role", "status");

    // Buat elemen span untuk teks "Loading..."
    var spinnerText = document.createElement("span");
    spinnerText.className = "visually-hidden";
    spinnerText.innerText = "Loading...";

    // Masukkan elemen span ke dalam elemen spinner-border
    spinnerBorderDiv.appendChild(spinnerText);

    // Masukkan elemen spinner-border ke dalam elemen spinner
    spinnerDiv.appendChild(spinnerBorderDiv);

    // Masukkan elemen spinner ke dalam elemen body
    body.appendChild(spinnerDiv);
}