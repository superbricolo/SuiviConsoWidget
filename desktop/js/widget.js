/*
1  : Prix
2  : Consommation
3  : Puissance
4  : Variation
5  : Consommation du jour
6  : Statistique
7  : 7 derniers jours
8  : 4 dernière semaines
9  : 12 dernirs mois
10 : 7 derniers jours Euro
11 : 4 dernières semaine Euro
12 : 12 derniers mois Euro
13 : 12 derniers mois TTC
14 : Degré jours unifié par an
*/


$('header').hide();
$('footer').hide();
$('#div_mainContainer').css('margin-top', '-50px');
$('#wrap').css('margin-bottom', '0px');
$('.backgroundforJeedom').css('margin-top', '-50px').css('height','100%');
document.getElementById("menu").style.display = "none";

// Hide All Widget

document.getElementById("widget_tableau_prix").style.display = "none";
document.getElementById("widget_Consobox").style.display = "none";
document.getElementById("widget_gauge").style.display = "none";
document.getElementById("widget_variation").style.display = "none";
document.getElementById("widget_currentBox").style.display = "none";
document.getElementById("widget_statBox").style.display = "none";
document.getElementById("widget_Temp7jBox").style.display = "none";
document.getElementById("widget_Temp4sBox").style.display = "none";
document.getElementById("widget_Temp12mBox").style.display = "none";
document.getElementById("widget_DJU7jBox").style.display = "none";
document.getElementById("widget_DJU4sBox").style.display = "none";
document.getElementById("widget_DJU12mBox").style.display = "none";
document.getElementById("widget_YearTaxe").style.display = "none";
document.getElementById("widget_DJUBox").style.display = "none";
document.getElementById("widget_PluriYear").style.display = "none";
document.getElementById("widget_PluriYearEuro").style.display = "none";
document.getElementById("WidgetError").style.display = "none";

if (idequipement != "") {
    //Show Widget Selected
    if (widgetId == 1) {
        document.getElementById("widget_tableau_prix").style.display = "block";
    };

    if (widgetId == 2) {
        document.getElementById("widget_Consobox").style.display = "block";
    };

    if (widgetId == 3) {
        document.getElementById("widget_gauge").style.display = "block";

    };

    if (widgetId == 4) {
        document.getElementById("widget_variation").style.display = "block";

    };

    if (widgetId == 5) {
        document.getElementById("widget_currentBox").style.display = "block";

    };

    if (widgetId == 6) {
        document.getElementById("widget_statBox").style.display = "block";

    };

    if (widgetId == 7) {
        document.getElementById("widget_Temp7jBox").style.display = "block";
    };

    if (widgetId == 8) {
        document.getElementById("widget_Temp4sBox").style.display = "block";
    };

    if (widgetId == 9) {
        document.getElementById("widget_Temp12mBox").style.display = "block";
    };

    if (widgetId == 10) {
        document.getElementById("widget_DJU7jBox").style.display = "block";
    };

    if (widgetId == 11) {
        document.getElementById("widget_DJU4sBox").style.display = "block";
    };

    if (widgetId == 12) {
        document.getElementById("widget_DJU12mBox").style.display = "block";
    };

    if (widgetId == 13) {
        document.getElementById("widget_YearTaxe").style.display = "block";
    };

    if (widgetId == 14) {
        document.getElementById("widget_DJUBox").style.display = "block";
    };

	if (widgetId == 15) {
        document.getElementById("widget_PluriYear").style.display = "block";
    };

	if (widgetId == 16) {
        document.getElementById("widget_PluriYearEuro").style.display = "block";
    };
} else {
    document.getElementById("WidgetError").style.display = "block";
};
