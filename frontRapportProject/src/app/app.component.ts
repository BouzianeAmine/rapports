import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { convert } from '../conversion';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'frontRapportProject';
  fileBlob;
  b64Blob;

  constructor(private http: HttpClient){

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
      this.changeFile(file).then((base64: string): any => {
        let contentType = base64.split(',')[0];
        let content =base64.split(',')[1];
        this.fileBlob = convert(content);
        const data=
          {
            name:"testt",
            blob:this.fileBlob,
            type:contentType
        };
        console.log(data);
        fetch("http://localhost:8000/api/rapport",{method:"POST",body:JSON.stringify(data)}).then(res=>res.json()).then(data=>console.log(data)).catch(err=>console.error(err));
      });
    } else alert('Nothing')
  }
}
