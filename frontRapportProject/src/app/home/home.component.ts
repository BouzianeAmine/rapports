import { Component, OnInit } from '@angular/core';
import { Rapport } from '../models/rapport';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  rapports: Array<Rapport>;
  currentUser: User;
  filiere:string;
  constructor() {
    this.currentUser = JSON.parse(localStorage.getItem('user'));
  }

  ngOnInit() {
    fetch('http://localhost:8000/bootstrap.php/rapport', { method: 'POST', mode: 'cors', body: localStorage.getItem('user') })
      .then(res => res.json())
      .then((value: Array<Rapport>) => { this.rapports = value; console.log(this.rapports); });
  }

  handleFileInput(event) {
    const formData = new FormData();
    formData.append('file', event.target.files[0]);
    formData.append('user',JSON.stringify(this.currentUser));
    fetch("http://localhost:8000/uploader.php", { method: 'POST', mode: 'cors', body: formData })
      .then(res => {
        if (res.ok) {
          console.log('the file is uploaded')
        }
      })
  }
  /*changeFile(file) {
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
        let content = base64.split(',')[1];
        this.fileBlob = this.convertToBlob(content, type);
        const data =
        {
          name: file.name,
          blob: URL.createObjectURL(this.fileBlob),
          type: type
        };
        console.log(data);
        fetch("http://localhost:8000/api/rapport", { method: "POST", mode: "no-cors", body: JSON.stringify(data) }).then(data => console.log(data)).catch(err => console.error(err));
      });
    } else alert('Nothing')
  }
  
  private convertToBlob(b64Data, contentType) {
    const byteCharacters = atob(b64Data);
    const byteNumbers = new Array(byteCharacters.length);
    for (let i = 0; i < byteCharacters.length; i++) {
      byteNumbers[i] = byteCharacters.charCodeAt(i);
    }
    const byteArray = new Uint8Array(byteNumbers);
    return new Blob([byteArray], { type: contentType });
  }*/
}
