define(["jquery"],function(t){t.fn.circleDiagram=function(){var e=t(this).find("canvas")[0],a=e.dataset.lineWidth||1,i=e.getContext("2d"),r=e.width/2,n=e.height/2,h=e.width/2-Math.ceil(a/2),d=Math.PI/2,f=2*Math.PI;i.lineWidth=a,i.strokeStyle=e.dataset.backColor||"#ffffff",i.beginPath(),i.arc(r,n,h,-d,f-d,!1),i.stroke(),i.strokeStyle=e.dataset.stroke||"#000000";var s=e.dataset.percent||1;s<1&&(s=1);var c=s/100;i.beginPath(),i.arc(r,n,h,-d,f*c-d,!1),i.stroke()}});