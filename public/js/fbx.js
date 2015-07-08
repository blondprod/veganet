/**
 *
 * Created by blond.
 * File: fbx.js
 * Date: 24/03/15 - 21:23
 *
 */

var tab_store_id = new Array();
var tab_store_value = new Array();
var tab_store_machine = new Array();

//-- selectionne la checkbox dans les tables
function Sel_Mngt(ElementId,IsToBeAdded)
{
    ////console.log("ElementId::"+ElementId);
    ////console.log("IsToBeAdded::"+IsToBeAdded);
    var count = null;

    if(IsToBeAdded) {
        tab_store_id.push(parseInt(ElementId));
        count = (tab_store_id.indexOf(parseInt(ElementId))+1);
        ////console.log("if(IsToBeAdded)|"+tab_store_id.toString());
    }
    else{
        var ind_tab = tab_store_id.indexOf(parseInt(ElementId));
        count = (tab_store_id.indexOf(parseInt(ElementId)));
        ////console.log("ElementId|"+ElementId);
        ////console.log("tab_store_id|"+tab_store_id);
        ////console.log("ind_tab|"+ind_tab);

        if(ind_tab>=0){
            tab_store_id.splice(parseInt(ind_tab),1);
            ////console.log("if(ind_tab>=0)|"+tab_store_id.toString());
        }
        ////console.log("end|"+tab_store_id.toString());
    }
    ////console.log(tab_store_id.toString());
    ////console.log("nb:"+tab_store_id.indexOf(parseInt(ElementId)));
    if(document.getElementById('count')) {
        document.getElementById('count').value = tab_store_id.length;
    }
    if(document.getElementById('countCtrl')) {
        document.getElementById('countCtrl').value = tab_store_id.length;
        document.getElementById('countCtrl2').value = tab_store_id.length;
    }
}

//-- selectionne la checkbox dans les tables
function Sel_Mngt_value(ElementValue,IsToBeAdded)
{
    if(IsToBeAdded) {
        tab_store_value.push(parseInt(ElementValue));
    }
    else{
        var ind_tab = tab_store_value.indexOf(parseInt(ElementValue));
        if(ind_tab>=0){
            tab_store_value.splice(parseInt(ind_tab),1);
        }
    }

}

//-- selectionne la checkbox dans les tables
function Sel_Mngt_machine(ElementValue,IsToBeAdded)
{
    if(IsToBeAdded) {
        tab_store_machine.push(parseInt(ElementValue));
    }
    else{
        var ind_tab = tab_store_machine.indexOf(parseInt(ElementValue));
        if(ind_tab>=0){
            tab_store_machine.splice(parseInt(ind_tab),1);
        }
    }

}

//-- affiche le jour dans la navbar
function dateJour()
{
    var date = new Date();
    //var jour = date.getDay();
    var nombre = date.getDate();
    var mois = (date.getMonth()+1);
    ////console.log("mois::"+mois);
    var annee = date.getFullYear();
    //var array_jour = new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
    //var array_mois = new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    document.getElementById('dateJour').innerHTML = (nombre + " / " + mois + " / " + annee);
}

//-- affiche l'heure dans la navbar
function heure()
{
    var date = new Date();
    var heures = date.getHours();
    var minutes = date.getMinutes();
    var secondes = date.getSeconds();

    if (heures < 10) heures = "0" + heures;
    if (minutes < 10) minutes = "0" + minutes;
    if (secondes < 10) secondes = "0" + secondes;

    document.getElementById('heure').innerHTML = heures + ":" + minutes + ":" + secondes;
    setTimeout("heure()", 1000);
}

//-- affiche une alerte dans une modal
function getModalAlert(message)
{
    if(message != "") {
        document.getElementById("message").removeAttribute("hidden");
        document.getElementById("message").innerHTML = message;
    }
    $("#alert").modal("show");
}

//-- permt d'afficher la navbar
function getMenu(div)
{
    ////console.log("start");
    $.getJSON(
        'Base',
        {
            'action': 'getMenu',
            'async': '1'
        },
        function (data)
        {
            ////console.log("run");
            $('#' + div + '').html(data.SentData);
        }
    );
    ////console.log("end");
}

//-- permet de créer une liste select
function getSelect(div,action,id,bool)
{
    if(!id) id = "0";

    if(!bool) bool = "0";

    if(action && div) {
        $.getJSON(
            'Select',
            {
                'action': 'getListe',
                'class': action,
                'async': '1',
                //'async_data': '1', //-- utile pour ne pas refaire un .twig
                'id': id,
                'bool': bool
            },
            function (data)
            {
                $('#' + div + '').html(data.SentData);
            }
        );
        return true;
    }
    else return false;
}

//-- permet de créer une liste select en liaison avec la societe
function getSelectTlSociete(div,action,idsociete,id,idformat)
{
    if(!id) id = null;
    if(!idformat) idformat = '0';
    $.getJSON(
        'Select',
        {
            'action': 'getSelect'+action,
            'async': '1',
            'IDSociete': idsociete,
            'idformat': idformat,
            'ID': id
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les mzchines en rapport avec les secteurs
function getSelectSecteurTlMachine(sisse,div)
{
    //console.log(sisse);
    //console.log(div);
    $.getJSON(
        'Select',
        {
            'action': 'getListeSecteurTlMachine',
            'async': '1',
            'id': sisse.value
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les menus en rapport avec les societes
function getSelectSocieteTlMenu(sisse,div)
{
    $.getJSON(
        'Select',
        {
            'action': 'getListeSocieteTlMenu',
            'async': '1',
            'id': sisse.value
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les fonction en rapport avec les societes
function getSelectSocieteTlFonction(sisse,div,idfonction)
{
    if(!idfonction) idfonction = null;
    $.getJSON(
        'Select',
        {
            'action': 'getListeSocieteTlFonction',
            'async': '1',
            'IDFonction':idfonction,
            'id': sisse.value
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les membres en rapport avec les societes
function getSelectSocieteTlMembre(sisse,div)
{
    $.getJSON(
        'Select',
        {
            'action': 'getListeSocieteTlMembre',
            'async': '1',
            'id': sisse.value
        },
        function (data)
        {
            ////console.log(data);
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les groupe en rapport avec les societes
function getSelectSocieteTlGroupe(sisse,div)
{
    $.getJSON(
        'Select',
        {
            'action': 'getListeSocieteTlGroupe',
            'async': '1',
            'id': sisse.value
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les support en rapport avec les societes
function getSelectSocieteTlSupport(sisse,div,IDSupport)
{
    ////console.log("this: "+sisse);
    ////console.log("div: "+div);
    ////console.log("IDSupport: "+IDSupport);

    if(!IDSupport) IDSupport = null;

    $.getJSON(
        'Select',
        {
            'action': 'getListeSocieteTlSupport',
            'async': '1',
            'IDSupport':IDSupport,
            'id': sisse.value
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les secteurs en rapport avec les societes
function getSelectSocieteTlSecteur(sisse,div,idsecteur)
{
    ////console.log(sisse);
    ////console.log(div);
    ////console.log(idsecteur);
    if(!idsecteur) idsecteur = null;
    $.getJSON(
        'Select',
        {
            'action': 'getListeSocieteTlSecteur',
            'async': '1',
            'IDSecteur':idsecteur,
            'id': sisse.value
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les code erreurs en rapport avec les societes
function getSelectSocieteTlCodeErreur(sisse,div)
{
    $.getJSON(
        'Select',
        {
            'action': 'getListeSocieteTlCodeErreur',
            'async': '1',
            'id': sisse.value
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les options en rapport avec les societes
function getSelectSocieteTlOption(idsociete,div,idoption)
{
    $.getJSON(
        'Select',
        {
            'action': 'getListeSocieteTlOption',
            'async': '1',
            'IDSociete': idsociete,
            'IDOption':idoption
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les pages en rapport avec les societes
function getSelectSocieteTlPage(sisse,div)
{
    $.getJSON(
        'Select',
        {
            'action': 'getListeSocieteTlPage',
            'async': '1',
            'id': sisse.value
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les option en rapport avec les secteurs
function getSelectOptionTlSecteur(idsecteur,div,idsociete)
{
    if(!idsociete) idsociete = '0';
    //if(!idsecteur) idsecteur = '0';

    $.getJSON(
        'Select',
        {
            'action':'getListeOptionTlSecteur',
            'async':'1',
            'IDSecteur':idsecteur,
            'IDSociete':idsociete
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les code erreur en rapport avec les secteurs
function getSelectCodeErreurTlSecteur(idsecteur,div,idsociete,idcode)
{
    if(!idsociete) idsociete = '0';
    if(!idcode) idcode = '0';
    ////console.log("idcode: "+idcode);

    $.getJSON(
        'Select',
        {
            'action':'getListeCodeErreurTlSecteur',
            'async':'1',
            'IDSecteur':idsecteur,
            'IDSociete':idsociete,
            'IDCode':idcode
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les fonction en rapport avec les groupes
function getSelectGroupeTLFonction(div,bis)
{
    if(!bis) bis = "";
    var id = ($('#selectGroupe'+bis+'').val());
    $.getJSON(
        'Select',
        {
            'action': 'getListeGroupeTLFonction',
            'async': '1',
            'id': id
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les membres en rapport avec les groupes
function getSelectGroupeTLMembre(div,bis)
{
    if(!bis) bis = "";
    var id = ($('#selectGroupe'+bis+'').val());
    $.getJSON(
        'Select',
        {
            'action': 'getListeGroupeTLMembre',
            'async': '1',
            'id': id
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- rempli les membres en rapport avec les fonctions
function getSelectFonctionTLMembre(div,bis)
{
    if(!bis) bis = "";
    var id = ($('#selectFonction'+bis+'').val());
    $.getJSON(
        'Select',
        {
            'action': 'getListeFonctionTLMembre',
            'async': '1',
            'id': id
        },
        function (data)
        {
            $('#' + div + '').html(data.SentData);
        }
    );
}

//-- permet d'ajouter une ligne dans les tables
function getAdd(id)
{
    ////console.log('AddRow');
    var tr = $('#'+id+'');
    tr.prop("hidden", false);
}

//-- efface de maniere logique une entree dans une table
function getDelete(id,tbl)
{
    $.getJSON(
        'Base',
        {
            'action': 'getDelete',
            'ID': tab_store_id,
            'Colonne': id,
            'Table': tbl,
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            //console.log(data);
        }
    );
    //location.reload();
    if (typeof(getMenu) == "function") { getMenu('navBarDyna'); }
    if (typeof(getTableGestionReglageAll) == "function") { getTableGestionReglageAll(); }
    if (typeof(getTableGestionDroitAll) == "function") { getTableGestionDroitAll(); }
    if (typeof(getTableMembre) == "function") { getTableMembre(); }

}

function collapse(div)
{
    ////console.log('div: '+div);
    setTimeout(function() { $('#' + div + '').collapse('toggle'); }, 750);
}

function checkInputText(div,lengt,maxi)
{
    if (!maxi) maxi = 4;

    div = $('#' + div + '');
    div.removeClass();

    if(lengt < maxi) {
        div.addClass('has-error');
        ////console.log('has-error lengt: '+lengt);
    }
    else{
        div.addClass('has-success');
        ////console.log('has-success lengt: '+lengt);
    }
}

function checkInputNumber(div,vis)
{
    div = $('#' + div + '');
    div.removeClass();

    ////console.log(vis.value);

    if($.isNumeric(vis.value)) div.addClass('has-success');
    else div.addClass('has-error');
}

function checkInputSelect(div,value)
{
    div = $('#' + div + '');
    div.removeClass();

    if(value == '0') {
        div.addClass('has-error');
        ////console.log('has-error value: '+value);
    }
    else{
        div.addClass('has-success');
        ////console.log('has-success value: '+value);
    }
}

function verifUpdateProfil()
{
    var Prenom = $('#Prenom').val().length;
    var Nom = $('#Nom').val().length;
    var IDLangue = $('#Langue').val();
    var Telephone = $('#Telephone').val().length;
    var Mail = $('#Email').val().length;
    var Login = $('#Login').val().length;
    var Pwd = $('#Pwd').val().length;

    if (Nom > 2 || Prenom > 2 || Login > 2 || Pwd > 2 || IDLangue > 0 || Telephone > 13 || Mail > 2 ){
        $('#saveProfil').prop("disabled", false);
    } else {
        $('#saveProfil').prop("disabled", true);
    }
}

function verifLiaison(div1,div2,btn)
{
    if (div1 && div2) {
        var a = $('#' + div1 + '').val();
        var b = $('#' + div2 + '').val();

        if (a != 0 && b != 0) {
            $('#'+btn+'').prop("disabled", false);
        } else {
            $('#'+btn+'').prop("disabled", true);
        }
    }
}

function getDossierDeFabPage(IP,PUBLIC_PATH,IDDossierDeFab)
{
    window.open('http://'+IP+'/'+PUBLIC_PATH+'Production?action=imp&IDDossierDeFab='+IDDossierDeFab+'','DossierDeFab', '');
}

function getDataPlanning()
{
    var IDMachine = document.getElementById('SelectMachine').value;
    var IDSecteur = document.getElementById('SelectSecteur').value;
    var modalPlanning = $('#modalPlanning');

    //console.info("IDMachine "+IDMachine);
    //console.info("IDSecteur "+IDSecteur);

    if ( IDMachine > '0' && IDSecteur > '0' ) {
        $.getJSON(
            'ProductionFicheDeProd',
            {
                'action': 'getDataPlanning',
                'async': '1',
                'IDMachine':IDMachine
            },
            function (data)
            {
                modalPlanning.html(data.SentData);
                modalPlanning.modal('show');
            }
        );
    }
}