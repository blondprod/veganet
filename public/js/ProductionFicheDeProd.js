/**
 *
 * Created by blond.
 * File: ProductionFicheDeProd.js
 * Date: 24/05/15 - 21:23
 *
 */
var IDSecteur = $('#SelectSecteur').val();
var IDMachine = $('#SelectMachine').val();

function getModifFicheDeProd(IDFicheDeProd)
{
    var commentaire = $('#UpFicheCommentaire_'+IDFicheDeProd+'').val();
    var selectSecteur = $('#UpFicheIDSecteur_'+IDFicheDeProd+'').val();

    ////console.log('UpFicheCommentaire_: '+commentaire);
    $('#tdUp_'+IDFicheDeProd+'').prop("hidden",true);
    $('#tdSave_'+IDFicheDeProd+'').prop("hidden",false);

    $('#btnRemove_'+IDFicheDeProd+'').prop("disabled",false);
    $('#divBtnRemove_'+IDFicheDeProd+'').prop("hidden",false);

    $('#tdFicheQuantite_'+IDFicheDeProd+'').html('<div id="divUpFicheQuantite_'+IDFicheDeProd+'"><input onkeyup="checkInputNumber(\'divUpFicheQuantite_'+IDFicheDeProd+'\',this);" id="UpFicheQuantite_'+IDFicheDeProd+'" class="form-control input-sm" type="number" value="'+$('#UpFicheQuantite_'+IDFicheDeProd+'').val()+'"></div>');
    $('#tdFicheNbPose_'+IDFicheDeProd+'').html('<div id="divFicheNbPose_'+IDFicheDeProd+'"><input onkeyup="checkInputNumber(\'divFicheNbPose_'+IDFicheDeProd+'\',this);" id="UpFicheNbPose_'+IDFicheDeProd+'" class="form-control input-sm" type="number" value="'+$('#UpFicheNbPose_'+IDFicheDeProd+'').val()+'"></div>');

    $('#tdFicheIDImpression_'+IDFicheDeProd+'').html('<div id="divFicheIdImpression_'+IDFicheDeProd+'"><select onchange="checkInputSelect(\'divFicheIdImpression_'+IDFicheDeProd+'\',this.value)" id="SelectImpressionFiche_'+IDFicheDeProd+'" class="form-control input-sm"></select></div>');
    getSelect('SelectImpressionFiche_'+IDFicheDeProd+'','getListeImpressionTrad',$('#UpFicheIDImpression_'+IDFicheDeProd+'').val());

    $('#tdFicheCode1_'+IDFicheDeProd+'').html('<select id="SelectFicheCode1up_'+IDFicheDeProd+'" class="form-control input-sm"></select>');
    getSelectCodeErreurTlSecteur(selectSecteur,'SelectFicheCode1up_'+IDFicheDeProd+'',0,$('#UpFicheCode1_'+IDFicheDeProd+'').val());

    $('#tdFicheCode2_'+IDFicheDeProd+'').html('<select id="SelectFicheCode2up_'+IDFicheDeProd+'" class="form-control input-sm"></select>');
    getSelectCodeErreurTlSecteur(selectSecteur,'SelectFicheCode2up_'+IDFicheDeProd+'',0,$('#UpFicheCode2_'+IDFicheDeProd+'').val());

    $('#tdFicheCommentaire_'+IDFicheDeProd+'').html('<div id="divUpFicheCommentaireUp_'+IDFicheDeProd+'"><input onkeyup="checkInputText(\'divUpFicheCommentaireUp_'+IDFicheDeProd+'\',this.value.length,3);" id="UpFicheCommentaireUp_'+IDFicheDeProd+'" class="form-control input-sm" type="text" value="'+commentaire+'"></div>');

}

function getUpdateFicheDeProd(IDFicheDeProd)
{
    var Quantite = $('#UpFicheQuantite_'+IDFicheDeProd+'').val();
    var Commentaire = $('#UpFicheCommentaireUp_'+IDFicheDeProd+'').val();
    var IDImpression = $('#SelectImpressionFiche_'+IDFicheDeProd+'').val();
    var Code1 = $('#SelectFicheCode1up_'+IDFicheDeProd+'').val();
    var OldCode1 = $('#UpFicheCode1_'+IDFicheDeProd+'').val();
    var Code2 = $('#SelectFicheCode2up_'+IDFicheDeProd+'').val();
    var OldCode2 = $('#UpFicheCode2_'+IDFicheDeProd+'').val();
    var NbPose = $('#UpFicheNbPose_'+IDFicheDeProd+'').val();;

    if (Quantite > 0 && IDImpression > 0) {
        ////console.log("IDFicheDeProd: "+IDFicheDeProd);
        ////console.log("Quantite: "+Quantite);
        ////console.log("IDImpression: "+IDImpression);
        ////console.log("IDSecteur: "+IDSecteur);
        ////console.log("IDMachine: "+IDMachine);
        $.getJSON(
            'ProductionFicheDeProd',
            {
                'action': 'getUpdateFicheDeProd',
                'async': '1',
                'async_data': '1',
                'IDFicheDeProd':IDFicheDeProd,
                'Quantite':Quantite,
                'IDImpression':IDImpression,
                'IDCode1':Code1,
                'OldCode1':OldCode1,
                'IDCode2':Code2,
                'OldCode2':OldCode2,
                'Commentaire':Commentaire,
                'NbPose':NbPose
            },
            function (data)
            {
                ////console.log("resu: "+data);
                getTableFicheDeProd(IDSecteur,IDMachine);
            }
        );
    }
}

function getCancelAction()
{
    $('#searchDateDossier').prop("disabled",false);
    $('#SelectSecteur').prop("disabled",false);
    $('#SelectMachine').prop("disabled",false);
    $('#Dossier').prop("disabled",false);
    $('#btnSearchDossier').prop("disabled",false);

    document.getElementById('btn_save').className = "btn btn-default btn-sm";
    $('#btn_save').prop('disabled',true);
    $('#divBtnCancel').prop("hidden",true);
    $('#saveRow').prop('hidden',true);
}

function getTableFicheDeProd(idsecteur,idmachine)
{

    if (!idmachine) idmachine = $('#SelectMachine').val();
    if (!idsecteur) idsecteur = $('#SelectSecteur').val();

    $.getJSON(
        'ProductionFicheDeProd',
        {
            'action': 'getDataTableProductionFicheDeProd',
            'IDSecteur': idsecteur,
            'IDMachine': idmachine,
            'searchDate': $('#searchDateDossier').val(),
            //'async_data': '1',
            'async': '1'
        },
        function (data) {
            ////console.log(data);
            $('#divTableFicheDeProdUser').html(data.SentData);
        }
    );
}

function getDataDossierDeFabTlElement(id)
{
    ////console.log(id);
    var option = '';
    var idoption = new Array();
    var idimp = '';

    getSelectTlSociete('SelectImpression','ImpressionTlMachine',$('#SelectSociete').val(),$('#SelectMachine').val());
    if (id != '') {
        $.getJSON(
            'ProductionFicheDeProd',
            {
                'action': 'getDataDossierDeFabTlElement',
                'async': '1',
                'async_data': '1',
                'Element': id,
                'IDDossierDeFab': $('#IDDossierDeFab').val(),
                'IDSecteur': $('#IDSecteur').val()
            },
            function (data) {
//                      //console.log(data);

                if (data['data_element'][0]['Commentaire'] != '') {
                    $('#tdCommentaireElement').html('<h4><span class="text text-danger glyphicon glyphicon-warning-sign tooltip-link" onclick="$(\'#spanCommentaireElement\').tooltip(\'show\')" id="spanCommentaireElement" title="' + data['data_element'][0]['Commentaire'] + '"></span></h4>');
                } else {
                    $('#tdCommentaireElement').html('');
                }
                $('#Quantite').val(data['data_element'][0]['Quantite']);
                $('#tdSelectSupport').html(data['data_element'][0]['NomSupport']);
                $('#tdSelectFormat').html(data['data_element'][0]['NomFormat']);
                //$("select#SelectImpression option[value="+data['data_element'][0]['IDImpression']+"]").attr("selected","selected");

                $('#hiddenSelectSupport').val(data['data_element'][0]['IDSupport']);
                $('#hiddenSelectFormat').val(data['data_element'][0]['IDFormat']);
                $('#hiddenSelectImpression').val(data['data_element'][0]['IDImpression']);
                for (i = 0; i <= (data['data_element_tl_option'].length - 1); i++) {
                    option = option + '<kbd>'+ data['data_element_tl_option'][i]['Nom'] + '</kbd>&nbsp;';
                    idoption.push( parseInt(data['data_element_tl_option'][i]['ID']));

                }
                $('#tdSelectOption').html(option);
                $('#hiddenArrayOption').val(idoption);
                //getSelect('SelectImpression','getListeImpressionTrad',data['data_element'][0]['IDImpression']);

                ////console.log($('#SelectMachine').val());
                verfiRow(data['data_element'][0]['Quantite'],data['data_element'][0]['IDImpression']);
                idimp = data['data_element'][0]['IDImpression'];
            }
        );
    } else {
        $('#tdCommentaireElement').html('');
        $('#Quantite').val('');
        $('#tdSelectSupport').html('');
        $('#tdSelectFormat').html('');
        //$('#tdSelectImpression').html('');
        $('#tdSelectOption').html('');
        //getSelect('SelectImpression','getListeImpressionTrad');
        getSelectTlSociete('SelectImpression','ImpressionTlMachine',$('#SelectSociete').val(),$('#SelectMachine').val());
    }
    setTimeout(function() {
        $("select#SelectImpression option[value="+idimp+"]").attr("selected","selected");
    }, 500);
}

function enabledRow(IDSociete)
{
    var searchDateDossier = $('#searchDateDossier');
    var dossier = $('#Dossier');
    var selectSociete = $('#SelectSociete');
    var selectSecteur = $('#SelectSecteur');
    var selectMachine = $('#SelectMachine');
    var btnSearchDossier = $('#btnSearchDossier');
    var select = '<option></option>';

    if( dossier.val()!='' && selectSecteur.val()>'0' && selectMachine.val()>'0' ) {
        $('#divBtnCancel').prop("hidden",false);
        searchDateDossier.prop('disabled',true);
        selectSociete.prop('disabled',true);
        selectSecteur.prop('disabled',true);
        selectMachine.prop('disabled',true);
        dossier.prop('disabled',true);
        btnSearchDossier.prop('disabled',true);

        $('#saveRow').prop('hidden',false);
        $('#tdDossier').html(dossier.val());

        $('#IDSociete').val(IDSociete);
        $('#IDSecteur').val(selectSecteur.val());
        $('#IDMachine').val(selectMachine.val());
        $('#inputDossier').val(dossier.val());
        $('#dDateDossier').val(searchDateDossier.val());

        getSelectTlSociete('SelectImpression','ImpressionTlMachine',$('#SelectSociete').val(),selectMachine.val());
        if(IDSociete>0){
            getSelectSocieteTlSupport(document.getElementById('SelectSociete'),'SelectSupport');
            getSelectTlSociete('SelectFormat','FormatTlSociete',IDSociete);
            getSelectCodeErreurTlSecteur(selectSecteur.val(),'SelectCodeErreur',IDSociete);
            getSelectCodeErreurTlSecteur(selectSecteur.val(),'SelectCodeErreur2',IDSociete);
            getSelectOptionTlSecteur(selectSecteur.val(),'SelectOption',IDSociete);
        } else {
            getSelect('SelectSupport','getListeSupportTrad');
            getSelect('SelectFormat','getListeFormatTrad');
//                    getSelect('SelectCodeErreur2','getListeCodeErreur');
            getSelectCodeErreurTlSecteur(selectSecteur.val(),'SelectCodeErreur');
            getSelectCodeErreurTlSecteur(selectSecteur.val(),'SelectCodeErreur2');
            getSelectOptionTlSecteur(selectSecteur.val(),'SelectOption');
        }
        //getSelect('SelectImpression','getListeImpressionTrad');


//      //console.log("test if exist DossierDeFab "+$('#inputDossier').val());
        $.getJSON(
            'ProductionFicheDeProd',
            {
                'action': 'getDataDossierDeFab',
                'async': '1',
                'async_data': '1',
                'Dossier': $('#inputDossier').val(),
                'IDSecteur':selectSecteur.val(),
                'IDMachine':selectMachine.val()
            },
            function (data)
            {
                var nbPose ;
                $('#IDDossierDeFab').val(data['data_DossierDeFab'][0]['IDDossierDeFab']);
                $('#tdRef').html(data['data_DossierDeFab'][0]['Ref']);
                $('#inputRef').val(data['data_DossierDeFab'][0]['Ref']);
                if(data['data_DossierDeFab'][0]['NbPose']==0) nbPose = '1';
                else nbPose = data['data_DossierDeFab'][0]['NbPose'];
                $('#NbPose').val(nbPose);
                if (data['data_DossierDeFab'][0]['Commentaire'] != '' ) $('#tdCommentaire').html('<h4><span class="text text-danger glyphicon glyphicon-exclamation-sign tooltip-link" onclick="$(\'#spanCommentaire\').tooltip(\'show\')" id="spanCommentaire" title="'+data['data_DossierDeFab'][0]['Commentaire']+'"></span></h4>');

                for (i = 0; i <= (data['data_Option'].length-1); i++) {
//                            //console.log(i + ' - ' + data['data_Option'][i]['Element']);
                    select = select+'<option value="'+data['data_Option'][i]['IDElement']+'">'+data['data_Option'][i]['Element']+'</option>';
                }
                $('#IDElement').html(select);
            }
        );
        $('#divJumbotron').prop("hidden",true);
    }
}

function verfiRow(quantite,idimpression)
{
    if (!quantite) quantite = $('#Quantite').val();
    if (!idimpression) idimpression = $('#SelectImpression').val();
    var btn = $('#btn_save');
    var element = $('#IDElement').val();

    ////console.log("quantite: "+quantite);
    ////console.log("idimpression: "+idimpression);
    ////console.log("element: "+element);

    if (element != '' && quantite > 0 && idimpression > 0) {
        document.getElementById('btn_save').className = "btn btn-success btn-sm";
        btn.prop("disabled",false);
    }
    else {
        document.getElementById('btn_save').className = "btn btn-default btn-sm";
        btn.prop("disabled",true);
    }
}

function getModalDeleteFicheDeProd(IDFicheDeProd)
{
    if(IDFicheDeProd != "") {
        $('#IDFicheDeProdModal').val(IDFicheDeProd);
    }
    $("#confirmation").modal("show");
}

function getDeleteFicheDeProd(IDFicheDeProd)
{
    if(IDFicheDeProd != "") {
        getDelete("IDFicheDeProd","TBL_FICHE_DE_PROD");
    }
    getTableFicheDeProd(IDSecteur,IDMachine);
    $("#confirmation").modal("hide");
}

function getBtnModalPlanning()
{
    var IDMachine = document.getElementById('SelectMachine').value;
    var IDSecteur = document.getElementById('SelectSecteur').value;

//        console.error("IDMachine "+IDMachine);
//        console.info("IDSecteur "+IDSecteur);

    //__ BUTTON APPEAR
    if ( IDMachine > '0' && IDSecteur > '0' ) { $('#divBtnPlanning').prop("hidden",false); }
    //__ BUTTON IS HIDDEN
    else { $('#divBtnPlanning').prop("hidden",true); }
}

function getDataDossierDeFabTlElementIntoFiche(IDElement,Dossier)
{
    if (IDElement && Dossier){
        $('#Dossier').val(Dossier);

        enabledRow($('#SelectSociete').val());

        //console.log("IDElement "+IDElement);

        $('#modalPlanning').modal("hide");
        setTimeout(function() {
            getDataDossierDeFabTlElement(IDElement);
            $("select#IDElement option[value="+IDElement+"]").attr("selected","selected");
        }, 500);

    }
}