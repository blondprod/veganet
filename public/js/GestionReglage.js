/**
 *
 * Created by blond.
 * File: GestionReglage.js
 * Date: 24/03/15 - 21:23
 *
 */

function getTableGestionReglageAll()
{
    getTableGestionReglage('Langue');
    getTableGestionReglage('Page');
    getTableGestionReglage('Menu');
    getTableGestionReglage('Secteur');
    getTableGestionReglage('Machine');
    getTableGestionReglage('Societe');
    getTableGestionReglage('CodeErreur');
    getTableGestionReglage('Support');
    getTableGestionReglage('Format');
    getTableGestionReglage('Element');
    getTableGestionReglage('Impression');
    getTableGestionReglage('Option');
}

function getTableGestionReglage(div)
{
    var idsociete = $('#SelectSociete').val();
    ////console.log('IDSocieteNavBar: ' + idsociete);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getDataTableGestion'+div,
            'IDSociete':idsociete,
            'async': '1'
        },
        function (data)
        {
            $('#tableGestion'+div+'').html(data.SentData);
            //////console.log(data);
        }
    );
    ////console.log('end');
}

function verifUpdateBrand(lengt,val)
{
    if (lengt > 2 ){
        $('#btnUpBrand').prop("disabled", false);
    } else {
        $('#btnUpBrand').prop("disabled", true);
    }
}

//__ LANGUE
function getInsertLangue()
{
    var tr = $('#tr_saveLangue');
    var nom = $('#nom_add');
    var bcp = $('#bcp_add');
    var actif = $('#actifLangue_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertLangue',
            'NomLangue':nom.val(),
            'CodeBCP':bcp.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            //////console.log(data);
        }
    );

    tr.prop("hidden", true);
    //location.reload();
    getMenu('navBarDyna');
    getTableGestionReglage('Langue');
    //getTableGestionReglageAll();
    ////getTableGestionDroitAll();
    collapse('collapseLangue');
}

function getModifLangue(id)
{
    var nom = $('#nom_' + id);
    var bcp = $('#bcp_' + id);
    var actif = $('#actifLangue_' + id);

    var modif = $('#modifLangue_' + id);
    var sauve = $('#saveLangue_' + id);

    nom.prop("disabled", false);
    bcp.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateLangue(id)
{
    var nom = $('#nom_' + id);
    var bcp = $('#bcp_' + id);
    var actif = $('#actifLangue_' + id);

    var modif = $('#modifLangue_' + id);
    var sauve = $('#saveLangue_' + id);

    nom.prop("disabled", true);
    bcp.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden",false);
    sauve.prop("hidden",true);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getUpdateLangue',
            'IDLangue':id,
            'NomLangue':nom.val(),
            'CodeBCP':bcp.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            //////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapseLangue');
}

function verifLangue(id)
{
    if(!id) id = "add";
    var Nom = $('#nom_'+id).val().length;
    var Bcp = $('#bcp_'+id).val().length;

    if (Nom > 2 && Bcp > 4 ){
        $('#btnInsertLangue_'+id).prop("disabled", false);
    } else {
        $('#btnInsertLangue_'+id).prop("disabled", true);
    }
}

//__MENU
function getInsertMenu()
{
    var tr = $('#tr_saveMenu');
    var nom = $('#NomMenu_add');
    var ordre = $('#OrdreMenu_add');
    var societe = $('#SocieteMenu_add');
    var actif = $('#ActifMenu_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertMenu',
            'NomMenu':nom.val(),
            'Ordre':ordre.val(),
            'IDSociete':societe.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            //////console.log(data);
        }
    );

    tr.prop("hidden", true);
    //location.reload();
    getMenu('navBarDyna');
    getTableGestionReglage('Menu');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    collapse('collapseMenu');
}

function getModifMenu(id)
{
    var nom = $('#NomMenu_' + id);
    var ordre = $('#OrdreMenu_' + id);
    var societe = $('#SocieteMenu_' + id);
    var actif = $('#ActifMenu_' + id);

    var modif = $('#modifMenu_' + id);
    var sauve = $('#saveMenu_' + id);

    nom.prop("disabled", false);
    ordre.prop("disabled", false);
    societe.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateMenu(id)
{
    var nom = $('#NomMenu_' + id);
    var ordre = $('#OrdreMenu_' + id);
    var societe = $('#SocieteMenu_' + id);
    var actif = $('#ActifMenu_' + id);

    var modif = $('#modifMenu_' + id);
    var sauve = $('#saveMenu_' + id);

    nom.prop("disabled", true);
    ordre.prop("disabled", true);
    societe.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden", false);
    sauve.prop("hidden", true);

    ////console.log('nom: ' + nom.val());
    ////console.log('IDlangue: ' + idlangue.val());
    ////console.log('Ordre: ' + ordre.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getUpdateMenu',
            'IDMenu': id,
            'NomMenu': nom.val(),
            'Ordre': ordre.val(),
            'IDSociete':societe.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            //////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapseMenu');
}

function verifMenu(id)
{
    if(!id) id = "add";
    var Nom = $('#NomMenu_'+id).val().length;
    var Ordre = $('#OrdreMenu_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertMenu_'+id).prop("disabled", false);
    } else {
        $('#btnInsertMenu_'+id).prop("disabled", true);
    }
}

//__ PAGE
//function getInsertPage()
//{
//    var tr = $('#tr_savePage');
//    var nom = $('#NomPage_add');
//    var ordre = $('#OrdrePage_add');
//    var actif = $('#actifPage_add');
//    var classPage = $('#classPage_add');
//    var ConstantePage = $('#ConstantePage_add');
//    var IDSociete = $('#SocietePage_add');
//    var id = $('#IDPage_add');
//
//    ////console.log("nom: "+nom.val());
//    ////console.log("idlangue: "+idlangue.val());
//    ////console.log("ordre: "+ordre.val());
//    ////console.log("actif: "+actif.is(':checked') ? 1 : 0);
//    ////console.log("classPage: "+classPage.val());
//    ////console.log("id: "+id.val());
//
//    $.getJSON(
//        'GestionReglage',
//        {
//            'action': 'getInsertPage',
//            'ID': id.val(),
//            'NomPage':nom.val(),
//            'Ordre':ordre.val(),
//            'IDSociete':IDSociete.val(),
//            'EstActif':actif.is(':checked') ? 1 : 0,
//            'ClassPage':classPage.val(),
//            'ConstantePage':ConstantePage.val(),
//            'async': '1',
//            'async_data': '1'
//        },
//        function (data)
//        {
//            //////console.log(data);
//        }
//    );
//
//    tr.prop("hidden", true);
//    getMenu('navBarDyna');
//    //getTableGestionReglageAll();
//    //getTableGestionDroitAll();
//    //collapse('collapsePage');
//}

function getModifPage(id)
{
    var nom = $('#NomPage_' + id);
    var ordre = $('#OrdrePage_' + id);
    var IDSociete = $('#SocietePage_' + id);
    var actif = $('#ActifPage_' + id);

    var modif = $('#modifPage_' + id);
    var sauve = $('#savePage_' + id);

    nom.prop("disabled", false);
    //IDSociete.prop("disabled", false);
    ordre.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdatePage(id)
{
    var nom = $('#NomPage_' + id);
    var ordre = $('#OrdrePage_' + id);
    var IDSociete = $('#SocietePage_' + id);
    var actif = $('#ActifPage_' + id);

    var modif = $('#modifPage_' + id);
    var sauve = $('#savePage_' + id);

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
        'GestionReglage',
        {
            'action': 'getUpdatePage',
            'IDPage': id,
            'NomPage': nom.val(),
            'Ordre': ordre.val(),
            'IDSociete':IDSociete.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            //////console.log(data);
        }
    );
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapsePage');
}

function verifPage(id)
{
    if(!id) id = "add";
    var Nom = $('#NomPage_'+id).val().length;
    var Ordre = $('#OrdrePage_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertPage_'+id).prop("disabled", false);
    } else {
        $('#btnInsertPage_'+id).prop("disabled", true);
    }
}

//__SECTEUR
function getInsertSecteur()
{
    var tr = $('#tr_saveSecteur');
    var nom = $('#NomSecteur_add');
    var societe = $('#SocieteSecteur_add');
    var ordre = $('#OrdreSecteur_add');
    var actif = $('#ActifSecteur_add');
    var code = $('#CodeSecteur_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertSecteur',
            'NomSecteur':nom.val(),
            'IDSociete':societe.val(),
            'Ordre':ordre.val(),
            'Code':code.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );

    tr.prop("hidden", true);
    getMenu('navBarDyna');
    getTableGestionReglage('Secteur');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    collapse('collapseSecteur');
}

function getModifSecteur(id)
{
    var nom = $('#NomSecteur_' + id);
    var societe = $('#SocieteSecteur_' + id);
    var ordre = $('#OrdreSecteur_' + id);
    var code = $('#CodeSecteur_' + id);
    var actif = $('#ActifSecteur_' + id);

    var modif = $('#modifSecteur_' + id);
    var sauve = $('#saveSecteur_' + id);

    nom.prop("disabled", false);
    societe.prop("disabled", false);
    ordre.prop("disabled", false);
    code.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateSecteur(id)
{
    var nom = $('#NomSecteur_' + id);
    var societe = $('#SocieteSecteur_' + id);
    var ordre = $('#OrdreSecteur_' + id);
    var code = $('#CodeSecteur_' + id);
    var actif = $('#ActifSecteur_' + id);

    var modif = $('#modifSecteur_' + id);
    var sauve = $('#saveSecteur_' + id);

    nom.prop("disabled", true);
    ordre.prop("disabled", true);
    actif.prop("disabled", true);
    code.prop("disabled", true);

    modif.prop("hidden", false);
    sauve.prop("hidden", true);

    ////console.log('nom: ' + nom.val());
    ////console.log('IDlangue: ' + idlangue.val());
    ////console.log('Ordre: ' + ordre.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getUpdateSecteur',
            'IDSecteur': id,
            'NomSecteur': nom.val(),
            'IDSociete':societe.val(),
            'Ordre': ordre.val(),
            'Code': code.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            ////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapseSecteur');
}

function verifSecteur(id)
{
    if(!id) id = "add";

    var Nom = $('#NomSecteur_'+id).val().length;
    var Ordre = $('#OrdreSecteur_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertSecteur_'+id).prop("disabled", false);
    } else {
        $('#btnInsertSecteur_'+id).prop("disabled", true);
    }
}

//__SOCIETE
function getInsertSociete()
{
    var tr = $('#tr_saveSociete');
    var Nom = $('#NomSociete_add');
    var IDMembre = $('#MembreSociete_add');
    var Mail = $('#EmailSociete_add');
    var Telephone = $('#TelephoneSociete_add');
    var Adresse1 = $('#Adresse1Societe_add');
    var Adresse2 = $('#Adresse2Societe_add');
    var CodePostal = $('#CodePostaleSociete_add');
    var Ville = $('#VilleSociete_add');
    var Pays = $('#PaysSociete_add');
    var IDLangue = $('#LangueSociete_add');
    var actif = $('#ActifSociete_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertSociete',
            'NomSociete':Nom.val(),
            'Mail': Mail.val(),
            'Telephone': Telephone.val(),
            'IDMembre':IDMembre.val(),
            'Adresse1': Adresse1.val(),
            'Adresse2': Adresse2.val(),
            'CodePostal': CodePostal.val(),
            'Ville': Ville.val(),
            'Pays': Pays.val(),
            'IDLangue': IDLangue.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );

    tr.prop("hidden", true);
    getMenu('navBarDyna');
    getTableGestionReglage('Societe');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    collapse('collapseSociete');
}

function getModifSociete(id)
{
    var nom = $('#NomSociete_' + id);
    var IDMembre = $('#MembreSociete_'+id);
    var Mail = $('#EmailSociete_'+id);
    var Telephone = $('#TelephoneSociete_'+id);
    var Adresse1 = $('#Adresse1Societe_'+id);
    var Adresse2 = $('#Adresse2Societe_'+id);
    var CodePostal = $('#CodePostaleSociete_'+id);
    var Ville = $('#VilleSociete_'+id);
    var Pays = $('#PaysSociete_'+id);
    var IDLangue = $('#LangueSociete_'+id);
    var actif = $('#ActifSociete_' + id);

    var modif = $('#modifSociete_' + id);
    var sauve = $('#saveSociete_' + id);

    nom.prop("disabled", false);
    IDMembre.prop("disabled", false);
    Mail.prop("disabled", false);
    Telephone.prop("disabled", false);
    Adresse1.prop("disabled", false);
    Adresse2.prop("disabled", false);
    CodePostal.prop("disabled", false);
    Ville.prop("disabled", false);
    Pays.prop("disabled", false);
    IDLangue.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateSociete(id)
{
    var Nom = $('#NomSociete_' + id);
    var IDMembre = $('#MembreSociete_'+id);
    var Mail = $('#EmailSociete_'+id);
    var Telephone = $('#TelephoneSociete_'+id);
    var Adresse1 = $('#Adresse1Societe_'+id);
    var Adresse2 = $('#Adresse2Societe_'+id);
    var CodePostal = $('#CodePostaleSociete_'+id);
    var Ville = $('#VilleSociete_'+id);
    var Pays = $('#PaysSociete_'+id);
    var IDLangue = $('#LangueSociete_'+id);
    var actif = $('#ActifSociete_' + id);

    var modif = $('#modifSociete_' + id);
    var sauve = $('#saveSociete_' + id);

    Nom.prop("disabled", true);
    IDMembre.prop("disabled", true);
    Mail.prop("disabled", true);
    Telephone.prop("disabled", true);
    Adresse1.prop("disabled", true);
    Adresse2.prop("disabled", true);
    CodePostal.prop("disabled", true);
    Ville.prop("disabled", true);
    Pays.prop("disabled", true);
    IDLangue.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden",false);
    sauve.prop("hidden",true);

    ////console.log('nom: ' + nom.val());
    ////console.log('idsecteur: ' + idsecteur.val());
    ////console.log('Ordre: ' + ordre.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getUpdateSociete',
            'IDSociete': id,
            'NomSociete': Nom.val(),
            'IDMembre': IDMembre.val(),
            'Mail': Mail.val(),
            'Telephone': Telephone.val(),
            'Adresse1': Adresse1.val(),
            'Adresse2': Adresse2.val(),
            'CodePostal': CodePostal.val(),
            'Ville': Ville.val(),
            'Pays': Pays.val(),
            'IDLangue': IDLangue.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            ////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapseSociete');
}

function verifSociete(id)
{
    if(!id) id = "add";

    var Nom = $('#NomSociete_'+id).val().length;
    var IDMembre = $('#MembreSociete_'+id).val();
    var Mail = $('#EmailSociete_'+id).val().length;
    var Telephone = $('#TelephoneSociete_'+id).val().length;
    var Adresse1 = $('#Adresse1Societe_'+id).val().length;
    var Adresse2 = $('#Adresse2Societe_'+id).val().length;
    var CodePostal = $('#CodePostaleSociete_'+id).val();
    var Ville = $('#VilleSociete_'+id).val().length;
    var Pays = $('#PaysSociete_'+id).val().length;
    var IDLangue = $('#LangueSociete_'+id).val();
    //console.log((IDLangue));

    if (Nom > 2 || IDMembre > 0 || Mail != '' || Telephone != '' || Adresse1 != '' || Adresse2 != '' || CodePostal > 0 || Ville != '' || Pays != '' || IDLangue != '0' ){
        $('#btnInsertSociete_'+id).prop("disabled", false);
    } else {
        $('#btnInsertSociete_'+id).prop("disabled", true);
    }
}

//__MACHINE
function getInsertMachine()
{
    var tr = $('#tr_saveMachine');
    var nom = $('#NomMachine_add');
    var idsecteur = $('#SecteurMachine_add');
    var Societe = $('#SocieteMachine_add');
    var CalageMinMachine = $('#CalageMinMachine_add');
    var CalageFeuillesMachine = $('#CalageFeuillesMachine_add');
    var GachePour1000FeuillesMachine = $('#GachePour1000FeuillesMachine_add');
    var CadenceTourMinMachine = $('#CadenceTourMinMachine_add');
    var passages = $('#2passagesMachine_add');
    var ordre = $('#OrdreMachine_add');
    var actif = $('#ActifMachine_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertMachine',
            'NomMachine':nom.val(),
            'IDSecteur':idsecteur.val(),
            'IDSociete':Societe.val(),
            'CalageMin': CalageMinMachine.val(),
            'CalageFeuilles': CalageFeuillesMachine.val(),
            'GachePour1000Feuilles': GachePour1000FeuillesMachine.val(),
            'CadenceTourMin': CadenceTourMinMachine.val(),
            'passages': passages.is(':checked') ? 1 : 0,
            'Ordre':ordre.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );

    tr.prop("hidden", true);
    getMenu('navBarDyna');
    getTableGestionReglage('Machine');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    collapse('collapseMachine');
}

function getModifMachine(id)
{
    var nom = $('#NomMachine_' + id);
    var idsecteur = $('#SecteurMachine_' + id);
    var Societe = $('#SocieteMachine_' + id);
    var CalageMinMachine = $('#CalageMinMachine_' + id);
    var CalageFeuillesMachine = $('#CalageFeuillesMachine_' + id);
    var GachePour1000FeuillesMachine = $('#GachePour1000FeuillesMachine_' + id);
    var CadenceTourMinMachine = $('#CadenceTourMinMachine_' + id);
    var passages = $('#2passagesMachine_' + id);
    var ordre = $('#OrdreMachine_' + id);
    var actif = $('#ActifMachine_' + id);

    var modif = $('#modifMachine_' + id);
    var sauve = $('#saveMachine_' + id);

    nom.prop("disabled", false);
    idsecteur.prop("disabled", false);
    Societe.prop("disabled", false);
    CalageMinMachine.prop("disabled", false);
    CalageFeuillesMachine.prop("disabled", false);
    GachePour1000FeuillesMachine.prop("disabled", false);
    CadenceTourMinMachine.prop("disabled", false);
    passages.prop("disabled", false);
    ordre.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateMachine(id)
{
    var nom = $('#NomMachine_' + id);
    var idsecteur = $('#SecteurMachine_' + id);
    var Societe = $('#SocieteMachine_' + id);
    var CalageMinMachine = $('#CalageMinMachine_' + id);
    var CalageFeuillesMachine = $('#CalageFeuillesMachine_' + id);
    var GachePour1000FeuillesMachine = $('#GachePour1000FeuillesMachine_' + id);
    var CadenceTourMinMachine = $('#CadenceTourMinMachine_' + id);
    var passages = $('#2passagesMachine_' + id);
    var ordre = $('#OrdreMachine_' + id);
    var actif = $('#ActifMachine_' + id);

    var modif = $('#modifMachine_' + id);
    var sauve = $('#saveMachine_' + id);

    nom.prop("disabled", true);
    idsecteur.prop("disabled", true);
    Societe.prop("disabled", true);
    CalageMinMachine.prop("disabled", true);
    CalageFeuillesMachine.prop("disabled", true);
    GachePour1000FeuillesMachine.prop("disabled", true);
    CadenceTourMinMachine.prop("disabled", true);
    passages.prop("disabled", true);
    ordre.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden", false);
    sauve.prop("hidden", true);

    ////console.log('nom: ' + nom.val());
    ////console.log('idsecteur: ' + idsecteur.val());
    ////console.log('Ordre: ' + ordre.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getUpdateMachine',
            'IDMachine': id,
            'NomMachine': nom.val(),
            'IDsecteur': idsecteur.val(),
            'IDSociete':Societe.val(),
            'CalageMin': CalageMinMachine.val(),
            'CalageFeuilles': CalageFeuillesMachine.val(),
            'GachePour1000Feuilles': GachePour1000FeuillesMachine.val(),
            'CadenceTourMin': CadenceTourMinMachine.val(),
            'passages': passages.is(':checked') ? 1 : 0,
            'Ordre': ordre.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            ////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapseMachine');
}

function verifMachine(id)
{
    if(!id) id = "add";

    var Nom = $('#NomMachine_'+id).val().length;
    var IDSecteur = $('#SecteurMachine_'+id).val();
    var IDSociete = $('#SocieteMachine_' + id).val();
    var CalageMin = $('#CalageMinMachine_'+id).val();
    var CalageFeuilles = $('#CalageFeuillesMachine_'+id).val();
    var CadenceTourMin = $('#CadenceTourMinMachine_'+id).val();
    var GachePour1000Feuilles = $('#GachePour1000FeuillesMachine_'+id).val();
    var Ordre = $('#OrdreMachine_'+id).val();

    if (Nom > 2 && IDSecteur > 0 && $.isNumeric(CalageMin) && $.isNumeric(CalageFeuilles) && $.isNumeric(CadenceTourMin) && $.isNumeric(GachePour1000Feuilles) && $.isNumeric(Ordre) ){
        $('#btnInsertMachine_'+id).prop("disabled", false);
    } else {
        $('#btnInsertMachine_'+id).prop("disabled", true);
    }
}

//__CODE ERREUR
function getInsertCodeErreur()
{
    var tr = $('#tr_saveCodeErreur');
    var nom = $('#NomCodeErreur_add');
    var societe = $('#SocieteCodeErreur_add');
    var ordre = $('#OrdreCodeErreur_add');
    var actif = $('#ActifCodeErreur_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertCodeErreur',
            'NomCodeErreur':nom.val(),
            'IDSociete':societe.val(),
            'Ordre':ordre.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );

    tr.prop("hidden", true);
    //location.reload();
    getMenu('navBarDyna');
    getTableGestionReglage('CodeErreur');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    collapse('collapseCodeErreur');
}

function getModifCodeErreur(id)
{
    var nom = $('#NomCodeErreur_' + id);
    var ordre = $('#OrdreCodeErreur_' + id);
    var societe = $('#SocieteCodeErreur_' + id);
    var actif = $('#ActifCodeErreur_' + id);

    var modif = $('#modifCodeErreur_' + id);
    var sauve = $('#saveCodeErreur_' + id);

    nom.prop("disabled", false);
    societe.prop("disabled", false);
    ordre.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateCodeErreur(id)
{
    var nom = $('#NomCodeErreur_' + id);
    var societe = $('#SocieteCodeErreur_' + id);
    var ordre = $('#OrdreCodeErreur_' + id);
    var actif = $('#ActifCodeErreur_' + id);

    var modif = $('#modifCodeErreur_' + id);
    var sauve = $('#saveCodeErreur_' + id);

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
        'GestionReglage',
        {
            'action': 'getUpdateCodeErreur',
            'IDCodeErreur': id,
            'NomCodeErreur': nom.val(),
            'IDSociete':societe.val(),
            'Ordre': ordre.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            ////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapseCodeErreur');
}

function verifCodeErreur(id)
{
    if(!id) id = "add";

    var Nom = $('#NomCodeErreur_'+id).val().length;
    var Ordre = $('#OrdreCodeErreur_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertCodeErreur_'+id).prop("disabled", false);
    } else {
        $('#btnInsertCodeErreur_'+id).prop("disabled", true);
    }
}

//__SUPPORT
function getInsertSupport()
{
    var tr = $('#tr_saveSupport');
    var nom = $('#NomSupport_add');
    var ordre = $('#OrdreSupport_add');
    var societe = $('#SocieteSupport_add');
    var actif = $('#ActifSupport_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertSupport',
            'NomSupport':nom.val(),
            'Ordre':ordre.val(),
            'IDSociete':societe.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );

    tr.prop("hidden", true);
    //location.reload();
    getMenu('navBarDyna');
    getTableGestionReglage('Support');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    collapse('collapseSupport');
}

function getModifSupport(id)
{
    var nom = $('#NomSupport_' + id);
    var ordre = $('#OrdreSupport_' + id);
    var societe = $('#SocieteSupport_' + id);
    var actif = $('#ActifSupport_' + id);

    var modif = $('#modifSupport_' + id);
    var sauve = $('#saveSupport_' + id);

    nom.prop("disabled", false);
    ordre.prop("disabled", false);
    societe.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateSupport(id)
{
    var nom = $('#NomSupport_' + id);
    var ordre = $('#OrdreSupport_' + id);
    var societe = $('#SocieteSupport_' + id);
    var actif = $('#ActifSupport_' + id);

    var modif = $('#modifSupport_' + id);
    var sauve = $('#saveSupport_' + id);

    nom.prop("disabled", true);
    ordre.prop("disabled", true);
    societe.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden", false);
    sauve.prop("hidden", true);

    ////console.log('nom: ' + nom.val());
    ////console.log('IDlangue: ' + idlangue.val());
    ////console.log('Ordre: ' + ordre.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getUpdateSupport',
            'IDSupport': id,
            'NomSupport': nom.val(),
            'Ordre': ordre.val(),
            'IDSociete':societe.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            ////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapseSupport');
}

function verifSupport(id)
{
    if(!id) id = "add";
    var Nom = $('#NomSupport_'+id).val().length;
    var Ordre = $('#OrdreSupport_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertSupport_'+id).prop("disabled", false);
    } else {
        $('#btnInsertSupport_'+id).prop("disabled", true);
    }
}

//__ELEMENT
function getInsertElement()
{
    var tr = $('#tr_saveElement');
    var nom = $('#NomElement_add');
    var ordre = $('#OrdreElement_add');
    var societe = $('#SocieteElement_add');
    var actif = $('#ActifElement_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertElement',
            'NomElement':nom.val(),
            'Ordre':ordre.val(),
            'IDSociete':societe.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );

    tr.prop("hidden", true);
    //location.reload();
    getMenu('navBarDyna');
    getTableGestionReglage('Element');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    collapse('collapseElement');
}

function getModifElement(id)
{
    var nom = $('#NomElement_' + id);
    var ordre = $('#OrdreElement_' + id);
    var societe = $('#SocieteElement_' + id);
    var actif = $('#ActifElement_' + id);

    var modif = $('#modifElement_' + id);
    var sauve = $('#saveElement_' + id);

    nom.prop("disabled", false);
    ordre.prop("disabled", false);
    societe.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateElement(id)
{
    var nom = $('#NomElement_' + id);
    var ordre = $('#OrdreElement_' + id);
    var societe = $('#SocieteElement_' + id);
    var actif = $('#ActifElement_' + id);

    var modif = $('#modifElement_' + id);
    var sauve = $('#saveElement_' + id);

    nom.prop("disabled", true);
    ordre.prop("disabled", true);
    societe.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden", false);
    sauve.prop("hidden", true);

    ////console.log('nom: ' + nom.val());
    ////console.log('IDlangue: ' + idlangue.val());
    ////console.log('Ordre: ' + ordre.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getUpdateElement',
            'IDElement': id,
            'NomElement': nom.val(),
            'Ordre': ordre.val(),
            'IDSociete':societe.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            ////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapseElement');
}

function verifElement(id)
{
    if(!id) id = "add";
    var Nom = $('#NomElement_'+id).val().length;
    var Ordre = $('#OrdreElement_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertElement_'+id).prop("disabled", false);
    } else {
        $('#btnInsertElement_'+id).prop("disabled", true);
    }
}

//__FORMAT
function getInsertFormat()
{
    var tr = $('#tr_saveFormat');
    var nom = $('#NomFormat_add');
    var ordre = $('#OrdreFormat_add');
    var societe = $('#SocieteFormat_add');
    var actif = $('#ActifFormat_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertFormat',
            'NomFormat':nom.val(),
            'Ordre':ordre.val(),
            'IDSociete':societe.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );

    tr.prop("hidden", true);
    //location.reload();
    getMenu('navBarDyna');
    getTableGestionReglage('Format');
    //getTableGestionReglageAll();
    ////getTableGestionDroitAll();
    collapse('collapseFormat');
}

function getModifFormat(id)
{
    var nom = $('#NomFormat_' + id);
    var ordre = $('#OrdreFormat_' + id);
    var societe = $('#SocieteFormat_' + id);
    var actif = $('#ActifFormat_' + id);

    var modif = $('#modifFormat_' + id);
    var sauve = $('#saveFormat_' + id);

    nom.prop("disabled", false);
    ordre.prop("disabled", false);
    societe.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateFormat(id)
{
    var nom = $('#NomFormat_' + id);
    var ordre = $('#OrdreFormat_' + id);
    var societe = $('#SocieteFormat_' + id);
    var actif = $('#ActifFormat_' + id);

    var modif = $('#modifFormat_' + id);
    var sauve = $('#saveFormat_' + id);

    nom.prop("disabled", true);
    ordre.prop("disabled", true);
    societe.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden", false);
    sauve.prop("hidden", true);

    ////console.log('nom: ' + nom.val());
    ////console.log('IDlangue: ' + idlangue.val());
    ////console.log('Ordre: ' + ordre.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getUpdateFormat',
            'IDFormat': id,
            'NomFormat': nom.val(),
            'Ordre': ordre.val(),
            'IDSociete':societe.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            ////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapseFormat');
}

function verifFormat(id)
{
    if(!id) id = "add";
    var Nom = $('#NomFormat_'+id).val().length;
    var Ordre = $('#OrdreFormat_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertFormat_'+id).prop("disabled", false);
    } else {
        $('#btnInsertFormat_'+id).prop("disabled", true);
    }
}

//__IMPRESSION
function getInsertImpression()
{
    var tr = $('#tr_saveImpression');
    var nom = $('#NomImpression_add');
    var ordre = $('#OrdreImpression_add');
    var nbcalage = $('#CalageImpression_add');
    var nbtour = $('#TourImpression_add');
    var societe = $('#SocieteImpression_add');
    var actif = $('#ActifImpression_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertImpression',
            'NomImpression':nom.val(),
            'Ordre':ordre.val(),
            'NbCalage':nbcalage.val(),
            'NbTour':nbtour.val(),
            'IDSociete':societe.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            //////console.log(data);
        }
    );

    tr.prop("hidden", true);
    //location.reload();
    getMenu('navBarDyna');
    getTableGestionReglage('Impression');
    //getTableGestionReglageAll();
    ////getTableGestionDroitAll();
    collapse('collapseImpression');
}

function getModifImpression(id)
{
    var nom = $('#NomImpression_' + id);
    var ordre = $('#OrdreImpression_' + id);
    var nbcalage = $('#CalageImpression_' + id);
    var nbtour = $('#TourImpression_' + id);
    var societe = $('#SocieteImpression_' + id);
    var actif = $('#ActifImpression_' + id);

    var modif = $('#modifImpression_' + id);
    var sauve = $('#saveImpression_' + id);

    nom.prop("disabled", false);
    ordre.prop("disabled", false);
    nbcalage.prop("disabled", false);
    nbtour.prop("disabled", false);
    societe.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateImpression(id)
{
    var nom = $('#NomImpression_' + id);
    var ordre = $('#OrdreImpression_' + id);
    var nbcalage = $('#CalageImpression_' + id);
    var nbtour = $('#TourImpression_' + id);
    var societe = $('#SocieteImpression_' + id);
    var actif = $('#ActifImpression_' + id);

    var modif = $('#modifImpression_' + id);
    var sauve = $('#saveImpression_' + id);

    nom.prop("disabled", true);
    ordre.prop("disabled", true);
    nbcalage.prop("disabled", true);
    nbtour.prop("disabled", true);
    societe.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden", false);
    sauve.prop("hidden", true);

    ////console.log('nom: ' + nom.val());
    ////console.log('IDlangue: ' + idlangue.val());
    ////console.log('nbtour: ' + nbtour.val());
    ////console.log('nbcalage: ' + nbcalage.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getUpdateImpression',
            'IDImpression': id,
            'NomImpression': nom.val(),
            'Ordre': ordre.val(),
            'IDSociete':societe.val(),
            'NbCalage':nbcalage.val(),
            'NbTour':nbtour.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            //////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    ////getTableGestionReglageAll();
    ////getTableGestionDroitAll();
    ////collapse('collapseImpression');
}

function verifImpression(id)
{
    if(!id) id = "add";
    var Nom = $('#NomImpression_'+id).val().length;
    var Ordre = $('#OrdreImpression_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertImpression_'+id).prop("disabled", false);
    } else {
        $('#btnInsertImpression_'+id).prop("disabled", true);
    }
}

//__OPTION
function getInsertOption()
{
    var tr = $('#tr_saveOption');
    var nom = $('#NomOption_add');
    var ordre = $('#OrdreOption_add');
    var societe = $('#SocieteOption_add');
    var actif = $('#ActifOption_add');

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getInsertOption',
            'NomOption':nom.val(),
            'Ordre':ordre.val(),
            'IDSociete':societe.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            ////console.log(data);
        }
    );

    tr.prop("hidden", true);
    //location.reload();
    getMenu('navBarDyna');
    getTableGestionReglage('Option');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    collapse('collapseOption');
}

function getModifOption(id)
{
    var nom = $('#NomOption_' + id);
    var ordre = $('#OrdreOption_' + id);
    var societe = $('#SocieteOption_' + id);
    var actif = $('#ActifOption_' + id);

    var modif = $('#modifOption_' + id);
    var sauve = $('#saveOption_' + id);

    nom.prop("disabled", false);
    ordre.prop("disabled", false);
    societe.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

function getUpdateOption(id)
{
    var nom = $('#NomOption_' + id);
    var ordre = $('#OrdreOption_' + id);
    var societe = $('#SocieteOption_' + id);
    var actif = $('#ActifOption_' + id);

    var modif = $('#modifOption_' + id);
    var sauve = $('#saveOption_' + id);

    nom.prop("disabled", true);
    ordre.prop("disabled", true);
    societe.prop("disabled", true);
    actif.prop("disabled", true);

    modif.prop("hidden", false);
    sauve.prop("hidden", true);

    ////console.log('nom: ' + nom.val());
    ////console.log('IDlangue: ' + idlangue.val());
    ////console.log('Ordre: ' + ordre.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    $.getJSON(
        'GestionReglage',
        {
            'action': 'getUpdateOption',
            'IDOption': id,
            'NomOption': nom.val(),
            'Ordre': ordre.val(),
            'IDSociete':societe.val(),
            'EstActif': actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data) {
            //////console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    //getTableGestionReglageAll();
    //getTableGestionDroitAll();
    //collapse('collapseOption');
}

function verifOption(id)
{
    if(!id) id = "add";
    var Nom = $('#NomOption_'+id).val().length;
    var Ordre = $('#OrdreOption_'+id).val();

    if (Nom > 2 && $.isNumeric(Ordre) ){
        $('#btnInsertOption_'+id).prop("disabled", false);
    } else {
        $('#btnInsertOption_'+id).prop("disabled", true);
    }
}