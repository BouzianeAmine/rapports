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
      username: this.email,
      password: this.password
    }
    fetch("http://localhost:8000/api/login_check", { method: 'POST', mode: 'cors' ,body: JSON.stringify(user) })
      .then(res => res.json())
      .then(rapports => console.log(rapports));
  }

}
