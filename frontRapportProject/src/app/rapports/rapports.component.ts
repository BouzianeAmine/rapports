import { Component, OnInit } from '@angular/core';
import {MatTableDataSource} from '@angular/material/table';

export interface Rapport {
  id:number;
  name: string;
  type: string;
  data: string;
  email:string;
}

@Component({
  selector: 'app-rapports',
  templateUrl: './rapports.component.html',
  styleUrls: ['./rapports.component.css']
})
export class RapportsComponent implements OnInit {
  displayedColumns: string[] = ['name', 'type', 'data'];
  dataSource:MatTableDataSource<Rapport>;
  fileBlob:Blob;
  rapports:Array<Rapport>;
  constructor() { 
    this.getRapports();
  }

  ngOnInit() {
  }

  changeFile(file) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result);
      reader.onerror = error => reject(error);
    });
  }

  uploadFile(event) {
    if (event.target.value) {
      const file = event.target.files[0] || event.dataTransfer.files[0];
      const type = file.type;
      console.log(file);
      this.changeFile(file).then((base64: string): any => {
        let content =base64.split(',')[1];
        this.fileBlob = this.convertToBlob(content,type);
        const data=
          {
            name:file.name,
            blob:URL.createObjectURL(this.fileBlob),
            type:type
        };
        console.log(data);
        fetch("http://localhost:8000/api/rapport",{method:"POST",mode:"no-cors",body:JSON.stringify(data)}).then(data=>console.log(data)).catch(err=>console.error(err));
      });
    } else alert('Nothing')
  }
  private convertToBlob(b64Data,contentType){
    const byteCharacters = atob(b64Data);
    const byteNumbers = new Array(byteCharacters.length);
    for (let i = 0; i < byteCharacters.length; i++) {
        byteNumbers[i] = byteCharacters.charCodeAt(i);
    }
    const byteArray = new Uint8Array(byteNumbers);
    return new Blob([byteArray], {type: contentType});
  }

  getRapports(){
     fetch('http://localhost:8000/rapports',{method:'GET',mode:'cors'}).then(res=>res.json()).then((rapports:Array<Rapport>)=>{ this.dataSource = new MatTableDataSource(rapports);});
  }

  applyFilter(filterValue: string) {
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }
}
