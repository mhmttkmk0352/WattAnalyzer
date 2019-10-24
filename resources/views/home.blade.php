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
    .karsilastirmaArayuzu canvas {
        min-height: 400px;
        max-height: 401px;
    }
    .genelortalamaArayuzu canvas {
        min-height: 400px;
        max-height: 401px;
    }

</style>


<div class="container pl-0 pr-0">
    <div class="row justify-content-center pl-0 pr-0">
        <div class="col-sm-10 pl-0 pr-0 pl-lg-5 pr-lg-5">
            <div class="card">
                <div class="card-header cardHeaderFooter">
                        <div class="row justify-content-center text-center">

                                {{-- <span class="cardTitle" style="font-weight: bold; font-size: 0.9em; color: #191919; display:none">
                                    Veri Karşılaştırma Arayüzü
                                </span> --}}





           
                                

                        </div>  
                </div>


                <div class="card-body" style="">    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   
                    <div class="row justify-content-center karsilastirmaArayuzu mx-0">
                        <div class="col-12">
                            <canvas id="myChart0" class="" style="width:100%; height:100%;"></canvas>
                        </div>                    
                    </div>
                    <div class="row">
                        <div class="col-12"><hr></div>
                    </div>
                    <div class="row justify-content-center karsilastirmaArayuzu mx-0">
                        <div class="col-12">
                            <canvas id="myChart1" class=""  style="width:100%; height:100%"></canvas>                              
                        </div>                          
                    </div>


                    <div class="row justify-content-center genelortalamaArayuzu mx-0 py-5">
                            <div class="col-12">
                                <canvas id="myChart2" class="" style="width:100%"></canvas>
                            </div>                    
                    </div>
                    <div class="row">
                        <div class="col-12"><hr></div>
                    </div>
                    <div class="row justify-content-center genelortalamaArayuzu mx-0 py-5">
                            <div class="col-12">
                                <canvas id="myChart3" class="" style="width:100%; height:100%"></canvas>
                            </div>                    
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

    $(".genelortalamaArayuzu").hide();




    $(document).on("click", ".karsilastirmaBtn", function(){
        $(".karsilastirmaArayuzu").hide();
        $(".genelortalamaArayuzu").hide();
        $(".karsilastirmaArayuzu").show();
    }); 
    $(document).on("click", ".genelortalamaBtn", function(){
        $(".karsilastirmaArayuzu").hide();
        $(".genelortalamaArayuzu").hide();
        $(".genelortalamaArayuzu").show();        
    });





    $(".dugmeler").fadeIn(1500);



        var datasets = '<?php print_r($data["datasets"]); ?>';
        var jpdatasets = JSON.parse(datasets);
    


        function sifirKoy(d){
            if (d<10){
                return "0"+d;
            }
            else{
                return d;
            }
        }

        var simdi = new Date();
        suan = sifirKoy(simdi.getHours())+":"+sifirKoy(simdi.getMinutes())+":"+sifirKoy(simdi.getSeconds());

        var ctx0 = document.getElementById('myChart0');
        var myChart0 = new Chart(ctx0, {
            type: 'line',
            data: {
                labels: ['3 Dk Öncesi','2 Dk Öncesi','1 Dk Öncesi','Son Veri('+suan+')'],            
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
                labels: ['3 Dk Öncesi','2 Dk Öncesi','1 Dk Öncesi','Şu an('+suan+')'],            
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

    
            console.log(jpdatasets);
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
                            label: 'watt değeri: ',
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






});










        </script>
        


@endsection
