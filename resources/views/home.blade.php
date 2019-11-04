@extends('layouts.app')
@section('content')


<script type="text/javascript" charset="utf8" src="../node_modules/chart.js/dist/Chart.js"></script>



<style>
    .cardHeaderFooter {
        background-color: rgba(0,0,0,0.03);       
    }
    .dugmeler {
        display: none;
    }
    .dugmeler:hover {
        background-color: lightseagreen;
        border: 1px solid lightseagreen;
    }


</style>


<div class="container pl-0 pr-0">
    <div class="row justify-content-center pl-0 pr-0">
        <div class="col-sm-10 pl-0 pr-0 pl-lg-5 pr-lg-5">
            <div class="card">
                <div class="card-header cardHeaderFooter">
                        <div class="row justify-content-center text-center">

                                <span class="cardTitle" style="font-weight: bold; font-size: 1em; color: #191919">
                                    
                                </span> 
  

                        </div>  
                </div>

                

                <div class="card-body cardMerkez" style="">    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                    <div class="row justify-content-center eszamanliArayuzu mx-0">
                        <canvas id="myChart11" class="" style="width:100%;"></canvas>
                        <div class="col-12"><hr></div>
                        <canvas id="myChart12" class="" style="width:100%;"></canvas>

                    </div>
                   

                    <div class="row justify-content-center karsilastirmaArayuzu mx-0">
                        <canvas id="myChart0" class="" style="width:100%;"></canvas>
                        <div class="col-12"><hr></div>
                        <canvas id="myChart1" class="" style="width:100%;"></canvas>

                    </div>

                    <div class="row justify-content-center genelortalamaArayuzu mx-0">
                        <canvas id="myChart2" class="" style="width:100%;"></canvas>
                        <div class="col-12"><hr></div>
                        <canvas id="myChart3" class="" style="width:100%;"></canvas>

                    </div>



                </div>


    

                <div class="card-footer cardHeaderFooter">
                        <div class="row justify-content-center">
                            <span class="cardTitle" style="font-weight: bold; font-size: 0.9em; display:none">
                                <a href="https://argebilisim.com.tr/"> argebilisim.com.tr </a>
                            </span>                        
                        </div>
                    </div>

            </div>
        </div>
    </div>


</div>





<script>



$(document).ready(function(){
    function arayuzHide(){
        $(".eszamanliArayuzu").hide();        
        $(".karsilastirmaArayuzu").hide();
        $(".genelortalamaArayuzu").hide();        
    }

    arayuzHide();
    $(".eszamanliArayuzu").show(); 


    $(document).on("click", ".karsilastirmaBtn", function(){
        arayuzHide();
        $(".karsilastirmaArayuzu").show();
    }); 
    $(document).on("click", ".genelortalamaBtn", function(){
        arayuzHide();
        $(".genelortalamaArayuzu").show();        
    });
    $(document).on("click", ".eszamanliBtn", function(){
        arayuzHide();
        $(".eszamanliArayuzu").show();         
    });





    function sifirKoy(d){
        if (d<10){
            return "0"+d;
        }
        else{
            return d;
        }
     }


    $(".dugmeler").fadeIn(1500);

        var datasets = "";
        var datasetsIlk = "";
        var anlikdegerTarihleri = "";
        datasets = '<?php print_r($data["datasets"]); ?>';
        datasetsIlk = '<?php print_r($data["datasetsIlk"]); ?>';
        anlikdegerTarihleri = '<?php if (isset($data["anlikdegerTarihleri"])){print_r($data["anlikdegerTarihleri"]);}else{print_r([]);}?>';

        
        if (datasets && datasetsIlk && anlikdegerTarihleri){

            $(".cardTitle").text("");

            var jpdatasets = JSON.parse(datasets);
            var jpdatasetsIlk = JSON.parse(datasetsIlk);

            console.log("<datasets>");
            console.log(jpdatasets);
            console.log("</datasets>");

            console.log("<datasetsIlk>");
            console.log(jpdatasetsIlk);
            console.log("</datasetsIlk>");


   
            var simdi = new Date();

            suan = sifirKoy(simdi.getHours())+":"+sifirKoy(simdi.getMinutes());



            var ctx11 = document.getElementById('myChart11').getContext('2d');
            var myChart11 = new Chart(ctx11, {
                type: 'line',
                data: {
                    labels: JSON.parse(anlikdegerTarihleri),            
                    datasets: jpdatasetsIlk
                },
                options: {
                    title: {
                        display: true,
                        text: "Çizgisel Analiz (Watt)"
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });



            var ctx12 = document.getElementById('myChart12').getContext('2d');
            var myChart12 = new Chart(ctx12, {
                type: 'bar',
                data: {
                    labels: ['∞','∞','∞','∞','∞','∞','∞','∞','∞','∞'],            
                    datasets: jpdatasetsIlk
                },
                options: {
                    title: {
                        display: true,
                        text: "Çizgisel Analiz (Watt)"
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });




            var ctx0 = document.getElementById('myChart0');
            var myChart0 = new Chart(ctx0, {
                type: 'line',
                data: {
                    labels: ['∞','∞','∞','∞','∞','∞','∞','∞','∞','∞'],            
                    datasets: jpdatasets
                },
                options: {
                    title: {
                        display: true,
                        text: "Çizgisel Analiz (Watt)"
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            var ctx1 = document.getElementById('myChart1');
            var myChart1 = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['∞','∞','∞','∞','∞','∞','∞','∞','∞','∞'],            
                    datasets: jpdatasets
                },
                options: {
                    title: {
                        display: true,
                        text: "Boyutsal Analiz (Watt)"
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            


            var ctx2 = document.getElementById('myChart2');


            
                let cihaz_idler = [];
                let avgValues = [];
                let backgroundColors = [];
                let borderColors = [];
                let avgPercents = [];
                let labels = [];
                let avgPercent = 0;
                jpdatasets.forEach(function(v,k){
                    avgPercent += (v.avgValue);
                });

                jpdatasets.forEach(function(v,k){
                    let yuzdeHesapla = (v.avgValue/avgPercent*100).toFixed(2);
                    cihaz_idler.push(v.label);
                    avgValues.push(v.avgValue);
                    avgPercents.push(yuzdeHesapla);
                    backgroundColors.push(v.backgroundColor);
                    borderColors.push(v.borderColor);
                    labels.push(v.label+"(%"+yuzdeHesapla+")");
                });

                var myChart2 = new Chart(ctx2, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: avgPercents,
                                backgroundColor: backgroundColors,
                                borderColor: borderColors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: "Toplam Enerjinin Yüzdesel Grafiği"
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }                    
                });

            

                var ctx3 = document.getElementById('myChart3');

                var myChart3 = new Chart(ctx3, {
                        type: 'bar',
                        data: {
                            labels: cihaz_idler,
                            datasets: [{
                                label: 'watt cinsinden: ',
                                data: avgValues,
                                backgroundColor: backgroundColors,
                                borderColor: borderColors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: "Genel Ortalama Grafiği"
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }                    
                });




        }
        else{
            $(".cardMerkez").hide();
            $(".cardTitle").text("Henüz Veri Mevcut Değil");
        }




});



        </script>
        


@endsection
