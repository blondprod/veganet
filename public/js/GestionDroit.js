/**
 *
 * Created by blond.
 * File: GestionDroit.js
 * Date: 24/03/15 - 21:23
 *
 */

function getTableGestionDroitAll()
{
    getTableGestionDroit('Groupe');
    getTableGestionDroit('Fonction');
    getTableGestionDroit('GroupeTlFonction');
    getTableGestionDroit('GroupeTlMenu');
    getTableGestionDroit('FonctionTlPage');
    getTableGestionDroit('MenuTlPage');
    getTableGestionDroit('SecteurTlCodeErreur');
    getTableGestionDroit('SupportTlFormat');
    getTableGestionDroit('SecteurTlOption');
    getTableGestionDroit('SecteurTlImpression');
    getSelect('SelectSocieteMenuTlPage','getListeSocieteTrad');
    getSelect('SelectSocieteFonctionTlPage','getListeSocieteTrad');
    getSelect('SelectSocieteGroupeTlFonction','getListeSocieteTrad');
    getSelect('SelectSocieteGroupeTlMenu','getListeSocieteTrad');
    getSelect('SelectSocieteSecteurTlCodeErreur','getListeSocieteTrad');
    getSelect('SelectSocieteSupportTlFormat','getListeSocieteTrad');
    getSelect('SelectSocieteSecteurTlOption','getListeSocieteTrad');
    getSelect('SelectSocieteSecteurTlImpression','getListeSocieteTrad');
}

function getTableGestionDroit(div)
{
    var idsociete = $('#SelectSociete').val();

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getDataTableGestion'+div,
            'IDSociete':idsociete,
            'async': '1'
        },
        function (data)
        {
            $('#tableGestion'+div+'').html(data.SentData);
            ////console.log(data);
        }
    );
    ////console.log('end');
}


//__ GROUPE
function getInsertGroupe()
{
    var tr = $('#tr_saveGroupe');
    var nom = $('#NomGroupe_add');
    var societe = $('#SocieteGroupe_add');
    var ordre = $('#OrdreGroupe_add');
    var actif = $('#ActifGroupe_add');

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getInsertGroupe',
            'NomGroupe':nom.val(),
            'IDSociete':societe.val(),
            'Ordre':ordre.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            //console.log(data);
        }
    );

    tr.prop("hidden", true);
    getMenu('navBarDyna');
    getTableGestionDroit('Groupe');
    //getTableGestionDroitAll();
    //getTableGestionReglageAll();
    //location.reload();
    collapse('collapseGroupe');
}

function getModifGroupe(id)
{
    var nom = $('#NomGroupe_' + id);
    var societe = $('#SocieteGroupe_' + id);
    var ordre = $('#OrdreGroupe_' + id);
    var actif = $('#ActifGroupe_' + id);

    var modif = $('#modifGroupe_' + id);
    var sauve = $('#saveGroupe_' + id);

    nom.prop("disabled", false);
    societe.prop("disabled", false);
    ordre.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateGroupe(id)
{
    var nom = $('#NomGroupe_' + id);
    var societe = $('#SocieteGroupe_' + id);
    var ordre = $('#OrdreGroupe_' + id);
    var actif = $('#ActifGroupe_' + id);

    var modif = $('#modifGroupe_' + id);
    var sauve = $('#saveGroupe_' + id);

    nom.prop("disabled", true);
    ordre.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden", false);
    sauve.prop("hidden", true);

    ////console.log('nom: ' + nom.val());
    ////console.log('Ordre: ' + ordre.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getUpdateGroupe',
            'IDGroupe': id,
            'NomGroupe': nom.val(),
            'IDSociete':societe.val(),
            'Ordre': ordre.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            //console.log(data);
        }
    );
    getMenu('navBarDyna');
    //getTableGestionDroitAll();
    //getTableGestionReglageAll();
    //location.reload();
    ////collapse('collapseGroupe');
}

function verifGroupe(id)
{
    if(!id) id = "add";
    var Nom = $('#NomGroupe_'+id).val().length;
    var Ordre = $('#OrdreGroupe_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertGroupe_'+id).prop("disabled", false);
    } else {
        $('#btnInsertGroupe_'+id).prop("disabled", true);
    }
}


//__ FONCTION
function getInsertFonction()
{
    var tr = $('#tr_saveFonction');
    var nom = $('#NomFonction_add');
    var ordre = $('#OrdreFonction_add');
    var actif = $('#ActifFonction_add');
    var societe = $('#SocieteFonction_add');

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getInsertFonction',
            'NomFonction':nom.val(),
            'Ordre':ordre.val(),
            'IDSociete':societe.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            //console.log(data);
        }
    );

    tr.prop("hidden", true);
    getMenu('navBarDyna');
    getTableGestionDroit('Fonction');
    //getTableGestionDroitAll();
    //getTableGestionReglageAll();
    //location.reload();
    collapse('collapseFonction');
}

function getModifFonction(id)
{
    var nom = $('#NomFonction_' + id);
    var ordre = $('#OrdreFonction_' + id);
    var actif = $('#ActifFonction_' + id);
    var societe = $('#SocieteFonction_' + id);

    var modif = $('#modifFonction_' + id);
    var sauve = $('#saveFonction_' + id);

    nom.prop("disabled", false);
    societe.prop("disabled", false);
    ordre.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateFonction(id)
{
    var nom = $('#NomFonction_' + id);
    var ordre = $('#OrdreFonction_' + id);
    var actif = $('#ActifFonction_' + id);
    var societe = $('#SocieteFonction_' + id);

    var modif = $('#modifFonction_' + id);
    var sauve = $('#saveFonction_' + id);

    nom.prop("disabled", true);
    ordre.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden", false);
    sauve.prop("hidden", true);

    ////console.log('nom: ' + nom.val());
    ////console.log('IDlangue: ' + idlangue.val());
    ////console.log('Ordre: ' + ordre.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getUpdateFonction',
            'IDFonction': id,
            'NomFonction': nom.val(),
            'IDSociete':societe.val(),
            'Ordre': ordre.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            //console.log(data);
        }
    );
    getMenu('navBarDyna');
    //getTableGestionDroitAll();
    //getTableGestionReglageAll();
    //location.reload();
    //collapse('collapseFonction');
}

function verifFonction(id)
{
    if(!id) id = "add";
    var Nom = $('#NomFonction_'+id).val().length;
    var Ordre = $('#OrdreFonction_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertFonction_'+id).prop("disabled", false);
    } else {
        $('#btnInsertFonction_'+id).prop("disabled", true);
    }
}


//__ GROUPE_TL_FONCTION
function getTableGroupeTlFonction(idgroupe,idsociete)
{
    $.getJSON(
        'GestionDroit',
        {
            'action': 'getDataGestionGroupeTlFonction',
            'IDGroupe':idgroupe,
            'IDSociete':idsociete,
            'async': '1'
        },
        function (data)
        {
            $('#tableGroupeTlFonction').html(data.SentData);
            ////console.log(data);
        }
    );
}

function getLiaisonGroupeTlFonction(chked,idfonction)
{
    //var idsociete = $('#SelectSocieteGroupeTlFonction').val();
    var idgroupe = $('#SelectGroupeGroupeTlFonction').val();

    ////console.log("IDSociete: "+idsociete +" - IDMenu: "+idmenu +" - chked: "+chked +" - IDPage: "+idpage);

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getLiaisonGroupeTlFonction',
            'IDGroupe':idgroupe,
            'IDFonction':idfonction,
            //'IDSociete':idsociete,
            'Actif':chked,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );
    getMenu('navBarDyna');
}


//__ GROUPE_TL_MENU
function getTableGroupeTlMenu(idgroupe,idsociete)
{
    $.getJSON(
        'GestionDroit',
        {
            'action': 'getDataGestionGroupeTlMenu',
            'IDGroupe':idgroupe,
            'IDSociete':idsociete,
            'async': '1'
        },
        function (data)
        {
            $('#tableGroupeTlMenu').html(data.SentData);
            ////console.log(data);
        }
    );
}

function getLiaisonGroupeTlMenu(chked,idmenu)
{
    //var idsociete = $('#SelectSocieteGroupeTlMenu').val();
    var idgroupe = $('#SelectGroupeGroupeTlMenu').val();

    ////console.log("IDSociete: "+idsociete +" - IDMenu: "+idmenu +" - chked: "+chked +" - IDPage: "+idpage);

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getLiaisonGroupeTlMenu',
            'IDGroupe':idgroupe,
            'IDMenu':idmenu,
            //'IDSociete':idsociete,
            'Actif':chked,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );
    getMenu('navBarDyna');
}


//__ MENU_TL_PAGE
function getTableMenuTlPage(idmenu,idsociete)
{
    $.getJSON(
        'GestionDroit',
        {
            'action': 'getDataGestionMenuTlPage',
            'IDMenu':idmenu,
            'IDSociete':idsociete,
            'async': '1'
        },
        function (data)
        {
            $('#tableMenuTlPage').html(data.SentData);
            ////console.log(data);
        }
    );
}

function getLiaisonMenuTlPage(chked,idpage)
{
    //var idsociete = $('#SelectSocieteMenuTlPage').val();
    var idmenu = $('#SelectMenuMenuTlPage').val();

    ////console.log("IDSociete: "+idsociete +" - IDMenu: "+idmenu +" - chked: "+chked +" - IDPage: "+idpage);

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getLiaisonMenuTlPage',
            'IDMenu':idmenu,
            'IDPage':idpage,
            //'IDSociete':idsociete,
            'Actif':chked,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );
    getMenu('navBarDyna');
}


//__ FONCTION_TL_PAGE
function getTableFonctionTlPage(idfonction,idsociete)
{
    $.getJSON(
        'GestionDroit',
        {
            'action': 'getDataGestionFonctionTlPage',
            'IDFonction':idfonction,
            'IDSociete':idsociete,
            'async': '1'
        },
        function (data)
        {
            $('#tableFonctionTlPage').html(data.SentData);
            ////console.log(data);
        }
    );
}

function getLiaisonFonctionTlPage(chked,idpage)
{
    //var idsociete = $('#SelectSocieteFonctionTlPage').val();
    var idfonction = $('#SelectFonctionFonctionTlPage').val();

    ////console.log("IDSociete: "+idsociete +" - IDFonction: "+idfonction +" - chked: "+chked +" - IDPage: "+idpage);

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getLiaisonFonctionTlPage',
            'IDFonction':idfonction,
            'IDPage':idpage,
            //'IDSociete':idsociete,
            'Actif':chked,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );
    getMenu('navBarDyna');
}


//__ SECTEUR_TL_CODE_ERREUR
function getTableSecteurTlCodeErreur(idgroupe,idsociete)
{
    $.getJSON(
        'GestionDroit',
        {
            'action': 'getDataGestionSecteurTlCodeErreur',
            'IDSecteur':idgroupe,
            'IDSociete':idsociete,
            'async': '1'
        },
        function (data)
        {
            $('#tableSecteurTlCodeErreur').html(data.SentData);
            ////console.log(data);
        }
    );
}

function getLiaisonSecteurTlCodeErreur(chked,idcodeerreur)
{
    //var idsociete = $('#SelectSocieteSecteurTlCodeErreur').val();
    var idsecteur = $('#SelectSecteurSecteurTlCodeErreur').val();

    ////console.log("IDSociete: "+idsociete +" - IDSecteur: "+idfonction +" - chked: "+chked +" - IDCodeErreur: "+idpage);

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getLiaisonSecteurTlCodeErreur',
            'IDSecteur':idsecteur,
            'IDCodeErreur':idcodeerreur,
            //'IDSociete':idsociete,
            'Actif':chked,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );
    getMenu('navBarDyna');
}


//__ SECTEUR_TL_OPTION
function getTableSecteurTlOption(idsecteur,idsociete)
{
    $.getJSON(
        'GestionDroit',
        {
            'action': 'getDataGestionSecteurTlOption',
            'IDSecteur':idsecteur,
            'IDSociete':idsociete,
            'async': '1'
        },
        function (data)
        {
            $('#tableSecteurTlOption').html(data.SentData);
            ////console.log(data);
        }
    );
}

function getLiaisonSecteurTlOption(chked,idoption)
{
    //var idsociete = $('#SelectSocieteSecteurTlOption').val();
    var idsecteur = $('#SelectSecteurSecteurTlOption').val();

    ////console.log("IDSecteur: "+idsecteur +" - chked: "+chked +" - IDOption: "+idoption);

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getLiaisonSecteurTlOption',
            'IDSecteur':idsecteur,
            'IDOption':idoption,
            //'IDSociete':idsociete,
            'Actif':chked,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );
    getMenu('navBarDyna');
}

//__ SECTEUR_TL_IMPRESSION
function getTableSecteurTlImpression(idsecteur,idsociete)
{
    $.getJSON(
        'GestionDroit',
        {
            'action': 'getDataGestionSecteurTlImpression',
            'IDSecteur':idsecteur,
            'IDSociete':idsociete,
            'async': '1'
        },
        function (data)
        {
            $('#tableSecteurTlImpression').html(data.SentData);
            ////console.log(data);
        }
    );
}

function getLiaisonSecteurTlImpression(chked,idimpression)
{
    //var idsociete = $('#SelectSocieteSecteurTlImpression').val();
    var idsecteur = $('#SelectSecteurSecteurTlImpression').val();

    ////console.log("IDSecteur: "+idsecteur +" - chked: "+chked +" - IDImpression: "+idimpression);

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getLiaisonSecteurTlImpression',
            'IDSecteur':idsecteur,
            'IDImpression':idimpression,
            //'IDSociete':idsociete,
            'Actif':chked,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );
    getMenu('navBarDyna');
}


//__ SUPPORT_TL_FORMAT
function getTableSupportTlFormat(idsupport,idsociete)
{
    $.getJSON(
        'GestionDroit',
        {
            'action': 'getDataGestionSupportTlFormat',
            'IDSupport':idsupport,
            'IDSociete':idsociete,
            'async': '1'
        },
        function (data)
        {
            $('#tableSupportTlFormat').html(data.SentData);
            ////console.log(data);
        }
    );
}

function getLiaisonSupportTlFormat(chked,idformat)
{
    //var idsociete = $('#SelectSocieteSupportTlFormat').val();
    var idsupport = $('#SelectSupportSupportTlFormat').val();

    ////console.log("IDSociete: "+idsociete +" - IDFormat: "+idformat +" - chked: "+chked +" - IDPage: "+idpage);

    $.getJSON(
        'GestionDroit',
        {
            'action': 'getLiaisonSupportTlFormat',
            'IDSupport':idsupport,
            'IDFormat':idformat,
            //'IDSociete':idsociete,
            'Actif':chked,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );
    getMenu('navBarDyna');
}

