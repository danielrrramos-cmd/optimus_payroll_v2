import { Component, OnInit, signal } from '@angular/core';
import { RouterLink, ActivatedRoute } from '@angular/router';
import { CommonModule } from '@angular/common';
import { NominaService } from '../../services/nomina.service';
import { Nomina } from '../../models/models';

@Component({
  selector: 'app-nominas',
  standalone: true,
  imports: [RouterLink, CommonModule],
  templateUrl: './nominas.component.html',
  styleUrl: './nominas.component.css'
})
export class NominasComponent implements OnInit {
  nominas = signal<Nomina[]>([]);
  empleadoId: number | null = null;
  empleadoNombre = signal<string>('');

  constructor(
    private nominaService: NominaService,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.route.queryParamMap.subscribe(params => {
      const id = params.get('empleado_id');
      this.empleadoId = id ? +id : null;
      this.nominaService.getAll(this.empleadoId ?? undefined).subscribe(data => {
        this.nominas.set(data);
        if (data.length > 0 && this.empleadoId) {
          this.empleadoNombre.set(`${data[0].empleado.nombre} ${data[0].empleado.apellidos}`);
        }
      });
    });
  }

  abrirPDF(id: number): void {
    window.open(`/nominas/ver/${id}?print=1`, '_blank');
  }
}
