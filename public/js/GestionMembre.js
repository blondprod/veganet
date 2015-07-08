/**
 *
 * Created by blond.
 * File: GestionMembre.js
 * Date: 24/03/15 - 21:23
 *
 */

//__ get table membre
function getTableMembre(value)
{
    if (!value) value = $('#Societe').val();

    var Prenom = $('#Prenom').val();
    var Nom = $('#Nom').val();
    var Login = $('#Login').val();
    var Email = $('#Email').val();
    var Langue = $('#Langue').val();
    var Fonction = $('#selectFonction3').val();
    var Groupe = $('#selectGroupe3').val();
    var estActif = $('#estActif').val();
    var Telephone = $('#Telephone').val();

    if ( !Prenom ) Prenom = '-+null+-' ;
    if ( !Nom ) Nom = '-+null+-' ;
    if ( !Login ) Login = '-+null+-' ;
    if ( !Email ) Email = '-+null+-' ;
    if ( Langue == 0 || !Langue ) Langue = '-+null+-' ;
    if ( Fonction == 0 || !Fonction) Fonction = '-+null+-' ;
    if ( !Groupe ) Groupe = '-+null+-' ;
    if ( !estActif ) estActif = '-+null+-' ;
    if ( !Telephone ) Telephone = '-+null+-' ;
    ////console.log('estActif'+estActif);
    $.getJSON(
        'GestionMembre',
        {
            'action': 'getDataTableGestionMembre',
            'Prenom': Prenom,
            'Nom': Nom,
            'Login': Login,
            'Email': Email,
            'Langue': Langue,
            'Fonction': Fonction,
            'Groupe': Groupe,
            'estActif': estActif,
            'Telephone': Telephone,
            'IDSociete':value,
            'async': '1'
        },
        function (data)
        {
            $('#tableGestionMembre').html(data.SentData);
            ////console.log(data);
        }
    );
    ////console.log('end');
}

//__ insert
function getInsertMembre()
{
    var tr = $('#tr_saveMembre');
    var Nom = $('#NomMembre_add');
    var Prenom = $('#PrenomMembre_add');
    var IDFonction = $('#FonctionMembre_add');
    var Login = $('#LoginMembre_add');
    var Pwd = $('#PwdMembre_add');
    var IDLangue = $('#LangueMembre_add');
    var Telephone = $('#TelephoneMembre_add');
    var Mail = $('#MailMembre_add');
    var Societe = $('#SocieteMembre_add');
    var actif = $('#ActifMembre_add');

    $.getJSON(
        'GestionMembre',
        {
            'action': 'getInsertMembre',
            'Nom':Nom.val(),
            'Prenom':Prenom.val(),
            'IDFonction':IDFonction.val(),
            'Login':Login.val(),
            'Pwd':Pwd.val(),
            'IDLangue':IDLangue.val(),
            'Telephone':Telephone.val(),
            'Mail':Mail.val(),
            'IDSociete':Societe.val(),
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
    getTableMembre();
}

//__ disabled input before update
function getModifMembre(id)
{
    ////console.log('modif');
    var Nom = $('#NomMembre_'+id);
    var Prenom = $('#PrenomMembre_'+id);
    var IDFonction = $('#FonctionMembre_'+id);
    var Login = $('#LoginMembre_'+id);
    var Pwd = $('#PwdMembre_'+id);
    var IDLangue = $('#LangueMembre_'+id);
    var Telephone = $('#TelephoneMembre_'+id);
    var Mail = $('#MailMembre_' + id);
    var Societe = $('#SocieteMembre_' + id);
    var actif = $('#ActifMembre_'+id);

    var modif = $('#modifMembre_' + id);
    var sauve = $('#saveMembre_' + id);

    ////console.log('Nom: ' + Nom.val());
    ////console.log('Prenom: ' + Prenom.val());
    ////console.log('IDFonction: ' + IDFonction.val());
    ////console.log('Login: ' + Login.val());
    ////console.log('Pwd: ' + Pwd.val());
    ////console.log('IDLangue: ' + IDLangue.val());
    ////console.log('Telephone: ' + Telephone.val());
    ////console.log('Mail: ' + Mail.val());
    ////console.log('Actif: ' + actif.is(':checked') ? 1 : 0);

    Nom.prop("disabled", false);
    Prenom.prop("disabled", false);
    IDFonction.prop("disabled", false);
    Login.prop("disabled", false);
    Pwd.prop("disabled", false);
    IDLangue.prop("disabled", false);
    Telephone.prop("disabled", false);
    Mail.prop("disabled", false);
    Societe.prop("disabled", false);
    actif.prop("disabled", false);

    modif.prop("hidden",true);
    sauve.prop("hidden",false);
}

//__ update
function getUpdateMembre(id)
{
    var Nom = $('#NomMembre_'+id);
    var Prenom = $('#PrenomMembre_'+id);
    var IDFonction = $('#FonctionMembre_'+id);
    var Login = $('#LoginMembre_'+id);
    var Pwd = $('#PwdMembre_'+id);
    var IDLangue = $('#LangueMembre_'+id);
    var Telephone = $('#TelephoneMembre_'+id);
    var Mail = $('#MailMembre_' + id);
    var Societe = $('#SocieteMembre_' + id);
    var actif = $('#ActifMembre_'+id);

    var modif = $('#modifMembre_' + id);
    var sauve = $('#saveMembre_' + id);

    //Nom.prop("disabled", true);
    //Prenom.prop("disabled", true);
    //IDFonction.prop("disabled", true);
    //Login.prop("disabled", true);
    //Pwd.prop("disabled", true);
    //Telephone.prop("disabled", true);
    //Mail.prop("disabled", true);
    //actif.prop("disabled", true);
    //console.log(actif.is(':checked') ? 1 : 0);

    modif.prop("hidden",false);
    sauve.prop("hidden",true);

    $.getJSON(
        'GestionMembre',
        {
            'action': 'getUpdateMembre',
            'IDMembre': id,
            'Nom':Nom.val(),
            'Prenom':Prenom.val(),
            'IDFonction':IDFonction.val(),
            'Login':Login.val(),
            'Pwd':Pwd.val(),
            'IDLangue':IDLangue.val(),
            'Telephone':Telephone.val(),
            'IDSociete':Societe.val(),
            'Mail':Mail.val(),
            'EstActif':actif.is(':checked') ? 1 : 0,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            //console.log(data);
        }
    );
    //location.reload();
    getMenu('navBarDyna');
    getTableMembre();
}

//__ verifAddText
function verifAddText()
{
    var selectMembre = $('#selectMembre').val();
    ////console.log('selectMembre: '+ selectMembre);

    var IDtext1 = $('#IDtext1').val().length;
    var IDtext2 = $('#IDtext2').val().length;
    var IDtext3 = $('#IDtext3').val().length;
    var IDtext4 = $('#IDtext4').val().length;

    if (selectMembre > '0') {
        if (IDtext1 < 1 && IDtext2 < 1 && IDtext3 < 1 && IDtext4 < 1) {
            $('#saveText').prop("disabled", true);
        } else {
            $('#saveText').prop("disabled", false);
        }
    }  else {
            $('#saveText').prop("disabled", true);
    }
}

//__ verifAddImg
function verifAddImg()
{
    var selectMembre = $('#selectMembre2').val();
    ////console.log('selectMembre: '+ selectMembre);

    if (selectMembre > '0') {
        $('#saveImg').prop("disabled", false);
    } else {
        $('#saveImg').prop("disabled", true);
    }
}

function verifInsertMembre()
{
    var Nom = $('#NomMembre_add').val().length;
    var Prenom = $('#PrenomMembre_add').val().length;
    var IDFonction = $('#FonctionMembre_add').val();
    var Login = $('#LoginMembre_add').val().length;
    var Pwd = $('#PwdMembre_add').val().length;
    var IDLangue = $('#LangueMembre_add').val();
    var Telephone = $('#TelephoneMembre_add').val().length;
    var Mail = $('#MailMembre_add').val().length;

    if (Nom > 2 && Prenom > 2 && IDFonction > 0 && Login > 2 && Pwd > 2 && IDLangue > 0 && Telephone > 13 && Mail > 2 ){
        $('#btnInsertMembre').prop("disabled", false);
    } else {
        $('#btnInsertMembre').prop("disabled", true);
    }
}

function verifUpdateMembre(id)
{
    var Nom = $('#NomMembre_'+id).val().length;
    var Prenom = $('#PrenomMembre_'+id).val().length;
    var IDFonction = $('#FonctionMembre_'+id).val();
    var Login = $('#LoginMembre_'+id).val().length;
    var Pwd = $('#PwdMembre_'+id).val().length;
    var IDLangue = $('#LangueMembre_'+id).val();
    var IDSociete = $('#SocieteMembre_'+id).val();
    var Telephone = $('#TelephoneMembre_'+id).val().length;
    var Mail = $('#MailMembre_' + id).val().length;

    if (Nom > 2 && Prenom > 2 && IDFonction > 0 && Login > 2 && Pwd > 2 && IDLangue > 0 && Telephone > 13 && Mail > 2 ){
        $('#btnUpdateMembre_'+id).prop("disabled", false);
    } else {
        $('#btnUpdateMembre_'+id).prop("disabled", true);
    }
}
