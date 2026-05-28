import { Component, OnInit, signal } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { NominaService } from '../../../services/nomina.service';
import { AuthService } from '../../../services/auth.service';
import { Nomina, UserInfo } from '../../../models/models';

@Component({
  selector: 'app-ver-nomina',
  standalone: true,
  imports: [RouterLink, CommonModule],
  templateUrl: './ver-nomina.component.html',
  styleUrl: './ver-nomina.component.css'
})
export class VerNominaComponent implements OnInit {
  nomina = signal<Nomina | null>(null);
  empresa = signal<UserInfo | null>(null);
  today = new Date();

  constructor(
    private nominaService: NominaService,
    private authService: AuthService,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    const id = +this.route.snapshot.paramMap.get('id')!;
    const autoPrint = this.route.snapshot.queryParamMap.get('print') === '1';

    this.nominaService.getOne(id).subscribe(data => {
      this.nomina.set(data);
      if (autoPrint) {
        // Dar tiempo al navegador para renderizar antes de imprimir
        setTimeout(() => window.print(), 700);
      }
    });

    this.authService.getMe().subscribe(u => this.empresa.set(u));
  }

  nominaNumero(nom: Nomina): string {
    const d = new Date(nom.fecha);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const id = String(nom.id).padStart(4, '0');
    return `${year}-${month}-${id}`;
  }

  printNomina(): void {
    window.print();
  }
}
