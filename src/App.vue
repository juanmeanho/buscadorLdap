<template>
<v-app>
<v-container>
  <v-layout row wrap>
    <v-flex xs4 offset-xs4>
      <div>
        <form v-on:submit.prevent="buscar">
        <v-text-field
        class="mx-3"
        flat
        placeholder="Buscar"
        append-icon="search"
        outline
        single-line
        v-model="query"
        v.on="buscar"
      ></v-text-field>
        </form>
      </div>
    </v-flex>

  </v-layout>
  <v-layout wrap row >
    <v-flex xs8 offset-xs2 >
        <template v-if="results && results.length" elevation-20>
          <v-card  color="transparent" class="mb-3"  v-for="(result, index) in results" :key="index">
            <v-toolbar color="primary" dark height="50%">
              <v-flex class="text-xs-center">{{result.nombre}}</v-flex>
            </v-toolbar>
            <v-layout>
            <v-flex xs4>
            <v-card
                  color="blue lighten-1"  >         
                <v-flex class="text-xs-center">
                  <v-avatar size="180" class="mt-4">
                    <img  :src="result.foto" :alt="result.nombre">
                  </v-avatar>
                </v-flex>
              <v-layout>
                <v-flex class="text-xs-center mt-3">
                  <p class="headline font-weight-regular" style="color:black;">{{result.nombre}}</p>
                </v-flex>
              </v-layout>
            </v-card>
            </v-flex>
            <v-flex xs8 class="mt-1">
            <v-btn class="px-3" block flat>
              <v-icon medium left>picture_in_picture</v-icon>
                <h3 class="font-weight-light text-capitalize">Cédula de Identidad: {{ result.cedula }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>assignment_ind</v-icon>
                <h3 class="font-weight-light text-capitalize">Negocio: {{ result.negocio }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>place</v-icon>
                <h3 class="font-weight-light text-capitalize">Localidad: {{ result.localidad }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>local_phone</v-icon>
                <h3 class="font-weight-light text-capitalize">Extensión: {{ result.ext }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>phonelink_ring</v-icon>
                <h3 class="font-weight-light text-capitalize">Célular: {{ result.celular }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>mail_outline</v-icon>
                <h3 class="font-weight-light text-capitalize">correo: {{ result.correo }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>
            </v-flex>
            </v-layout>
            <v-layout>
            <v-flex>
            <v-expansion-panel>
              <v-expansion-panel-content>
                
              <div slot="header" class="text-xs-center"><h2>Mas Información...</h2></div>
              
              <v-btn class="px-3" block flat>
              <v-icon medium left>label</v-icon>
                <h3 class="font-weight-light text-capitalize">Empleado: {{ result.empleado }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>settings</v-icon>
                <h3 class="font-weight-light text-capitalize">cargo: {{ result.cargo }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>outlined_flag</v-icon>
                <h3 class="font-weight-light text-capitalize">Nómina: {{ result.nomina }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>directions</v-icon>
                <h3 class="font-weight-light text-capitalize">Área: {{ result.area }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>date_range</v-icon>
                <h3 class="font-weight-light text-capitalize">Aniversario: {{ result.aniversario }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>portrait</v-icon>
                <h3 class="font-weight-light text-capitalize">Supervisor: {{ result.supervisor }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>perm_media</v-icon>
                <h3 class="font-weight-light text-capitalize">Organización: {{ result.organizacion }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>location_city</v-icon>
                <h3 class="font-weight-light text-capitalize">Edificio: {{ result.edif }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
            <v-divider></v-divider>

            <v-btn class="px-3" block flat>
              <v-icon medium left>subject</v-icon>
                <h3 class="font-weight-light text-capitalize">Descripción: {{ result.descripcion }}</h3>
                <v-spacer></v-spacer>
            </v-btn>
              </v-expansion-panel-content>
            </v-expansion-panel>

            

            </v-flex>
            </v-layout>

          </v-card>
        </template>

        <p class="text-xs-center">{{error}}</p>
    </v-flex>
  </v-layout>
   <!-- <pre>{{$data}}</pre>  -->
  
        <v-dialog
          v-model="dialog"
          hide-overlay
          persistent
          width="300"
        >
          <v-card
            color="primary"
            dark
          >
            <v-card-text>
              Buscando...
              <v-progress-linear
                indeterminate
                color="white"
                class="mb-0"
              ></v-progress-linear>
            </v-card-text>
          </v-card>
        </v-dialog>
</v-container>
</v-app>
</template>

<script>
import axios from 'axios';

export default {
  name: 'App',
  components: {
  },
  data () {
    return {
      dialog: false,
      query: '',
      results: [],
      error: '',
      img:  [{ img: './assets/logo.png' }]
    }
  },
  methods: {
    buscar(){
      this.dialog = true
      axios.post('http://10.168.13.42/buscar/buscar.php?query='+this.query)
        .then(response => {
        
        this.error = ''
        this.results = []
        //console.log(response.status);
        // JSON responses are automatically parsed.
        if(response.data.error)
          this.error = response.data.error
        else
        
          this.results = response.data

        this.dialog = false
      })
    }
  }
}
</script>
