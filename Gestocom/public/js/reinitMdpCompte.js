function reinitMdpCompte() {
    var txt;
    var r = confirm("Pour confirmer, appuie sur \"OK\" !");
    if (r == true) {
      txt = "Mot de passe réinitialisé en \"test\" !";
    } else {
      txt = "Annulation de la réinitialisation du mot de passe";
    }
    document.getElementById("demo").innerHTML = txt;
  }