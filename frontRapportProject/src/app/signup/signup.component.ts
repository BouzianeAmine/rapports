import { Component, OnInit, Input } from '@angular/core';
import {validate} from '../../../middleWears/validator'
@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {
  @Input()
  email:string;
  @Input()
  password:string;
  @Input()
  firsname:string;
  @Input()
  lastname:string;
  @Input()
  promotion:string;

  constructor() { }

  ngOnInit() {
  }
  
  signUp(){
    validate(this.email).then(res=>console.log(res)).catch(err=>console.error(err));
  }

}
