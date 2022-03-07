
class Teeth
{
    //properties
    createTooth(toothClass,toothId)
    {
        let wrapper=document.createElement("span");
        wrapper.className="icon";

        let tooth=document.createElement("i");
        tooth.className=toothClass;
        tooth.id=toothId;

        wrapper.appendChild(tooth);
        return wrapper;
    }
    createTableData(toothClass,toothId,tableDataClass)
    {
        let td=document.createElement("td");
        td.className=tableDataClass;
        td.appendChild(this.createTooth(toothClass,toothId));
        return td;
    }
    createTableRow()
    {
        let tr=document.createElement("tr");
        return tr;
    }
    createTableHead()
    {
        let th=document.createElement("th");
        th.className="text-center";
        return th;
    }
    renderTeethTable(chartId,tableClass)
    {
        let counter=1,bottom_counter;
        let limit=16;
        let chart=document.getElementById(chartId);
        let table=document.createElement("table");
        table.className=tableClass;
        while(counter<=4)
        {
            let row=this.createTableRow();
            if(counter==1)
            {
                for(let i=1;i<=limit;i++)
                {
                    let th=this.createTableHead();
                    th.append(i);
                    row.appendChild(th);
                }
            }
            if(counter==4)
            {
                let new_limit=32;
                for(let i=new_limit;i>limit;i--)
                {
                    let th=this.createTableHead();
                    th.append(i);
                    row.appendChild(th);
                }
            }
            if(counter==2)
            {
                for(let i=1;i<=limit;i++)
                {
                    row.append(this.createTableData("dc-teeth dc-teeth-"+i,"tooth-"+i,"upper-group"));
                }
            }
            if(counter==3)
            {
                let new_limit=32;
                bottom_counter=32;
                for(let i=17;i<=new_limit;i++)
                {
                    row.append(this.createTableData("dc-teeth dc-teeth-"+i,"tooth-"+bottom_counter,"bottom-group"));
                    bottom_counter--;
                }
            }
            
            table.appendChild(row);
            counter++;
        }
        chart.appendChild(table);
    }

}
