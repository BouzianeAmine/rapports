import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {
  @Input() email: string;
  @Input() password: string;
  constructor() { }

  ngOnInit() {
  }

  connect() {
    const user = {
      email: this.email,
      password: this.password
    };
    fetch("http://localhost:8000/connect", { method: 'POST',mode:'cors',body:JSON.stringify(user)})
      .then(value=>value.json()).then(val=>console.log(val));
  }

}
