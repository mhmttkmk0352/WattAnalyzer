const port = 3000;
const express = require("express");
const app = express();

var hersey = {}

var c=(d)=>{
    console.log(d);
}


var yoksa=(d,q)=>{
    if (hersey){
        if (!hersey[d]){
            hersey[d] = {};
        }
        if (!hersey[d][q.c]){
            hersey[d][q.c] = { v:"", a:"", t:"" };
        }  
        
        let farkToplam = 0;

        if (hersey[d]){
            if (typeof hersey[d] == "object"){
                let l = Object.keys(hersey[d]).length;
                for (item in hersey[d]){
                    if (item == item){
                    }else{
                        let fark = parseInt(parseInt(q.t)-parseInt(hersey[d][item].t));
               
                        if (fark>farkToplam){
                            farkToplam = fark;
                        }
                        c("+");
                        c(farkToplam);
                    }

                }
            }         
        }
        
        hersey[d][q.c].v = q.v;
        hersey[d][q.c].a = q.a;
        hersey[d][q.c].t = q.t;
        c("hersey: ");
        c(hersey);

    }
}

app.get("/", (req, res)=>{
    if (res){
        res.send("Anasayfa");
        console.log(req.query);
        if (req && req.query && req.query.u){
            yoksa(req.query.u, req.query);
        }
        
    }
});

app.listen(port, ()=>{
    c(port+". PORT Dinlemede");
});
