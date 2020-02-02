import { Component, OnInit, Input } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {
  @Input() email: string;
  @Input() password: string;
  constructor(private httpCall:HttpClient) { }

  ngOnInit() {
  }

  connect() {
    const user = {
      email: this.email,
      password: this.password
    }
    fetch("http://localhost:8000/connect", { method: 'POST', mode: 'no-cors' ,body:JSON.parse(JSON.stringify(user))})
      .then(res => res.json()).then(value=>console.log(value));
  }

}
