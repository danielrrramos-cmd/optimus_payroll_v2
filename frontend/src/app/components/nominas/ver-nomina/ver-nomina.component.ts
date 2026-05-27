import { Component, OnInit, signal } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { NominaService } from '../../../services/nomina.service';
import { Nomina } from '../../../models/models';

@Component({
  selector: 'app-ver-nomina',
  standalone: true,
  imports: [RouterLink, CommonModule],
  templateUrl: './ver-nomina.component.html',
  styleUrl: './ver-nomina.component.css'
})
export class VerNominaComponent implements OnInit {
  nomina = signal<Nomina | null>(null);

  constructor(private nominaService: NominaService, private route: ActivatedRoute) {}

  ngOnInit(): void {
    const id = +this.route.snapshot.paramMap.get('id')!;
    this.nominaService.getOne(id).subscribe(data => this.nomina.set(data));
  }
}
