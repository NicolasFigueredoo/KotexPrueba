<template>
    <div>
        <div class="informacionProducto">
            <div class="imgMinis">
                <div>
                    <img src="../../img/kotex.jpg" alt="" ref="imgMiniUno" @click="imagenClick(1, 'kotex.jpg')"
                        style="cursor: pointer;" />
                </div>
                <div>
                    <img src="../../img/imgNosotros2.png" alt="" ref="imgMiniDos"
                        @click="imagenClick(2, 'imgNosotros2.png')" style="cursor: pointer;" />
                </div>
            </div>
            <div class="contenedor-imagen">
                <img id="imgP" src="../../img/kotex.jpg" ref="imgenPrincipal" alt="" />
            </div>
            <div class="textos">
                <div class="categoriaI">
                    <p>{{ this.categoria.toUpperCase() }}</p>
                </div>
                <div class="nombreI">
                    <p>{{ nombreProducto.charAt(0).toUpperCase() + nombreProducto.slice(1) }}</p>
                </div>
                <div class="material">
                    <span>Material</span>
                    <p>Poliester, tipo, crochet</p>
                </div>
                <div class="tipo">
                    <span>Tipo</span>

                    <p>Crochet</p>
                </div>
                <div class="aplicaciones">
                    <p>Aplicaciones</p>
                    <div class="botonesAplicacion">
                        <div v-for="aplicacion in aplicaciones" :key="aplicacion.id">
                            <div>
                                <button type="button" class="btn btn-primary botonAplicacion">
                                    {{ aplicacion }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="medidas">
                    <p>Medidas</p>
                    <div class="botonesMedidas">
                        <div v-for="medida in medidas" :key="medida.id">
                            <div>
                                <button type="button" class="btn btn-primary botonMedida">
                                    {{ medida }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabla">
            <p>Presupuesto</p>
            <table class="table">
                <thead style="height: 40px">
                    <tr>
                        <th scope="col" class="encabezado">Categoria</th>
                        <th scope="col" class="encabezado">Nombre</th>
                        <th scope="col" class="encabezado">Color</th>
                        <th scope="col" class="encabezado">Medida</th>
                        <th scope="col" class="encabezado">Unidad de Venta</th>
                        <th scope="col" class="encabezado">Cant.</th>
                        <th class="encabezado"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-left: 0px;">
                            <select v-model="categoriaSeleccionada" class="form-select selects" id="categoria"
                                @change="obtenerProductosNombres">
                                <option value="" selected>Seleccione</option>
                                <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.nombre">{{
                        categoria.nombre }}</option>

                            </select>
                        </td>
                        <td class="rowT">
                            <select v-model="productoSeleccionado" class="form-select selects" id="nombre"
                                @change="obtenerColorProducto">
                                <option value="" selected>Seleccione</option>
                                <option v-for="producto in productosC" :key="producto.id" :value="producto.nombre">{{
                        producto.nombre }}</option>
                            </select>
                        </td>
                        <td class="rowT">
                            <select v-model="colorSeleccionado" class="form-select selects" id="color"
                                @change="obtenerMedidas">
                                <option value="" selected>Seleccione</option>
                                <option v-for="productoColor in coloresS" :key="productoColor.id"
                                    :value="productoColor">{{ productoColor }}</option>

                            </select>
                        </td>
                        <td class="rowT">
                            <select v-model="medidaSeleccionada" class="form-select selects" id="medida"
                                @change="obtenerUnidadVenta">
                                <option value="" selected>Seleccione</option>
                                <option v-for="medida in medidasS" :key="medida.id" :value="medida">{{ medida }}
                                </option>
                            </select>
                        </td>
                        <td class="rowT">
                            <select v-model="unidadSeleccionada" class="form-select selects" id="unidadventa">
                                <option value="" selected>Seleccione</option>
                                <option v-for="unidad in unidadesS" :key="unidad.id" :value="unidad">{{ unidad }}
                                </option>

                            </select>
                        </td>
                        <td style="padding-right: 0px">
                            <input v-model="cantidadSeleccionada" type="number" class="form-control inputCantidad"
                                placeholder="0" aria-label="Cantidad" aria-describedby="basic-addon2" min="0">
                        </td>

                        <td id="botonAgregar" style="padding-right: 0px; padding-left: 0px">
                            <button id="agregar" type="button" style="border-radius: 0%" class="btn btn-primary"
                                @click="guardarProducto">
                                Agregar
                            </button>
                        </td>
                    </tr>


                    <tr v-for="registro in registros" :key="registro.idRegistro">

                        <td>{{ registro.categoria }}</td>
                        <td>{{ registro.nombre }}</td>
                        <td>{{ registro.color }}</td>
                        <td>{{ registro.medida }}</td>
                        <td>{{ registro.unidadVenta }}</td>
                        <td>{{ registro.cantidad }}</td>
                        <td id="botonAgregar" style="padding-right: 0px; padding-left: 0px">
                            <button id="agregar" type="button" style="border-radius: 0%" class="btn btn-primary"
                                @click="deleteProducto(registro.idRegistro)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>
                            </button>
                        </td>

                    </tr>



                </tbody>
            </table>
            <div class="botones">

                <router-link class="route" to="/productosespeciales"
                    :style="{ fontWeight: isRouteActive('/productosespeciales') ? 'bold' : '500' }">
                    <button id="agregarProducto" type="button" style="border-radius: 0%" class="btn btn-primary"
                        @click="deleteProductoElegido()">
                        + AGREGAR MAS PRODUCTOS
                    </button>
                </router-link>

                <router-link class="route" to="/presupuesto"
                    :style="{ fontWeight: isRouteActive('/presupuesto') ? 'bold' : '500' }">

                    <button id="verPresupuesto" type="button" style="border-radius: 0%" class="btn btn-primary">
                        VER PRESUPUESTO
                    </button>
                </router-link>

            </div>
        </div>

        <div class="productosDestacados">
            <p class="productosD">Productos relacionados</p>
            <div>
                <Carousel :items-to-show="4" class="carouselP">
                    <Slide v-for="producto in productosRelacionados" :key="producto.id_producto">
                        <div class="carousel__item" @click="verProducto(producto.id_producto)">
                            <div class="producto">
                                <img src="../../img/kotexfooter.png" alt="imagen">
                                <p class="categoria">{{ producto.nombre_categoria }}</p>
                                <p class="nombre">{{ producto.nombre_producto }}</p>
                            </div>
                        </div>
                    </Slide>

                    <template #addons>
                        <Pagination />
                    </template>
                </Carousel>
            </div>
        </div>
    </div>
</template>

<script>
import AOS from "aos";
import axios from "axios";
import { Carousel, Navigation, Slide, Pagination } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';


export default {
    name: 'informacion Producto',
    components: {
        Pagination,
        Carousel,
        Slide,
        Navigation,

    },
    data() {
        return {
            registroCount: 1,
            productosRelacionados: [],
            medidas: [],
            aplicaciones: [],
            nombreProducto: "",
            categorias: [],
            productosC: [],
            medidasS: [],
            coloresS: [],
            unidadesS: [],
            categoria: '',
            categoriaId: null,
            categoriaSeleccionada: '',
            productoSeleccionado: '',
            colorSeleccionado: '',
            medidaSeleccionada: '',
            unidadSeleccionada: '',
            cantidadSeleccionada: '',
            settings: {
                itemsToShow: 1,
                snapAlign: 'center',
            },
            breakpoints: {
                700: {
                    itemsToShow: 3.5,
                    snapAlign: 'center',
                },
                1024: {
                    itemsToShow: 5,
                    snapAlign: 'start',
                },
            },
        };
    },

    computed: {
        registros() {
            const registros = this.$store.getters.obtenerRegistros;
            return registros;
        },

        idProducto() {
            const selectedProductId = this.$store.getters['getSelectedProductId'];
            return selectedProductId;
        }
    },
    methods: {
        obtenerInformacionProducto() {
            axios.get(`/api/obtenerInformacionProducto/${this.idProducto}`)
                .then((response) => {
                    this.medidas = response.data.medidas;
                    this.aplicaciones = response.data.aplicaciones;
                    this.nombreProducto = response.data.nombre_producto;
                    this.categoriaId = response.data.categorias[0];
                    this.categoria = response.data.categoriasNombre[0]

                    if (this.categoria === 'Productos de linea') {
                        this.obtenerProductosLinea();

                    } else {
                        this.obtenerProductosEspeciales();
                    }

                })
                .catch((error) => {
                    console.error(
                        "Error al obtener informacion producto:",
                        error
                    );
                });
        },

        obtenerProductosLinea() {
            axios.get('/api/obtenerProductosDeLinea')
                .then(response => {
                    this.productosRelacionados = response.data;
                })
                .catch(error => {
                    console.error('Error al traer los productos:', error);
                });
        },

        obtenerProductosEspeciales() {
            axios.get('/api/obtenerProductosEspeciales')
                .then(response => {
                    this.productosRelacionados = response.data;
                })
                .catch(error => {
                    console.error('Error al traer los productos:', error);
                });
        },

        obtenerCategorias() {
            axios.get(`/api/obtenerCategorias`)
                .then((response) => {
                    this.categorias = response.data
                })
                .catch((error) => {
                    console.error(
                        "Error al obtener categorias",
                        error
                    );
                });
        },

        obtenerProductosNombres() {
            axios.get(`/api/obtenerNombresProducto/${this.categoriaSeleccionada}`)
                .then((response) => {
                    this.productosC = response.data;

                })
                .catch((error) => {
                    console.error(
                        "Error al obtener informacion nombre producto:",
                        error
                    );
                });
        },

        obtenerColorProducto() {
            axios.get(`/api/obtenerColorProducto/${this.productoSeleccionado}`)
                .then((response) => {
                    this.coloresS = response.data
                })
                .catch((error) => {
                    console.error(
                        "Error al obtener medidas",
                        error
                    );
                });
        },

        obtenerMedidas() {
            axios.get(`/api/obtenerMedidasProducto`, {
                params: {
                    productoId: this.productoSeleccionado,
                    color: this.colorSeleccionado
                }
            })
                .then((response) => {
                    this.medidasS = response.data
                })
                .catch((error) => {
                    console.error(
                        "Error al obtener medidas",
                        error
                    );
                });
        },

        obtenerUnidadVenta() {
            axios.get(`/api/obtenerUnidadVenta`, {
                params: {
                    productoId: this.productoSeleccionado,
                    color: this.colorSeleccionado,
                    medida: this.medidaSeleccionada
                }
            })
                .then((response) => {
                    this.unidadesS = response.data
                })
                .catch((error) => {
                    console.error(
                        "Error al obtener unidad venta",
                        error
                    );
                });
        },

        guardarProducto() {
            if (
                this.categoriaSeleccionada &&
                this.productoSeleccionado &&
                this.colorSeleccionado &&
                this.medidaSeleccionada &&
                this.unidadSeleccionada &&
                this.cantidadSeleccionada
            ) {
                const nuevoRegistro = {
                    idRegistro: this.registroCount,
                    categoria: this.categoriaSeleccionada,
                    nombre: this.productoSeleccionado,
                    color: this.colorSeleccionado,
                    medida: this.medidaSeleccionada,
                    unidadVenta: this.unidadSeleccionada,
                    cantidad: this.cantidadSeleccionada
                };
                this.$store.commit('agregarRegistro', nuevoRegistro);
                this.registroCount += 1;
            } else {
                alert('Por favor, complete todos los campos antes de guardar.');
            }
        },

        deleteProductoElegido() {
            this.$store.commit('setSelectedProductId', null);
        },

        deleteProducto(idRegistro) {
            this.$store.commit('eliminarRegistro', idRegistro);
        },

        isRouteActive(route) {
            return this.$route.path === route;
        },

        verProducto(productId) {
            this.$store.commit('setSelectedProductId', productId);
            this.obtenerInformacionProducto();
            if (this.categoria === 'Productos de linea') {
                this.$router.push('/productosdelinea');

            } else {
                this.$router.push('/productosespeciales');
            }
        },

        imagenClick(idImagen, imagen) {
            let elemento = this.$refs.imgMiniUno;
            let elemento2 = this.$refs.imgMiniDos;
            let elemento3 = this.$refs.imgenPrincipal;
            if (idImagen === 1) {
                elemento2.style.border = 'none';
                elemento.style.border = '2px solid rgba(51, 68, 127, 1)';
                elemento3.src = '../../img/' + imagen;
            } else {
                elemento.style.border = 'none';
                elemento2.style.border = '2px solid rgba(51, 68, 127, 1)';
                elemento3.src = '../../img/' + imagen;

            }


        },




    },
    mounted() {

        AOS.init();
        this.obtenerCategorias();
        this.obtenerInformacionProducto();





    },

};
</script>

<style scoped>
.informacionProducto {
    display: flex;
    margin-left: 17%;
}

.textos {
    width: 600px;
    margin-left: 20px;
    margin-top: 20px;
}

.categoriaI {
    margin-left: 0px;
}

.categoriaI p {
    color: var(--azul, #33447f);
    font-family: "Montserrat";
    font-size: 18px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
    text-transform: uppercase;
}

.nombreI p {
    color: #000;
    font-family: "Montserrat";
    font-size: 35px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    margin-left: 0px;
}

.material span {
    color: #000;
    font-family: "Montserrat";
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}

.material p {
    color: #000;
    font-family: "Montserrat";
    font-size: 15px;
    font-style: normal;
    font-weight: 300;
    line-height: normal;
}

.tipo span {
    color: #000;
    font-family: "Montserrat";
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}

.tipo p {
    color: #000;
    font-family: "Montserrat";
    font-size: 15px;
    font-style: normal;
    font-weight: 300;
    line-height: normal;
}

.botonesAplicacion {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
}

.aplicaciones {
    margin-top: 20px;
}

.aplicaciones p {
    color: #000;
    font-family: "Montserrat";
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: 0px;
}

.botonAplicacion {
    height: 30px;
    font-size: 15px;
    border: none;
    background: var(--Gris, #9d9ea2);
    margin-top: 8px;
    margin-right: 5px;
    font-family: "Montserrat";
    font-weight: 400;
    flex: 1 0 auto;
    line-height: 18.29px;
}

.botonAplicacion:hover {
    height: 30px;
    font-size: 15px;
    border: none;
    background: var(--Gris, #9d9ea2);
    margin-top: 8px;
    margin-right: 5px;
    font-family: "Montserrat";
    font-weight: 400;
    flex: 1 0 auto;
    line-height: 18.29px;
}

.medidas {
    margin-top: 30px;
}

.medidas p {
    color: #000;
    font-family: Montserrat;
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: 0px;
}

.botonesMedidas {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
}

.botonMedida {
    height: 30px;
    font-size: 15px;
    border: none;
    background: var(--Gris, rgba(51, 68, 127, 1));
    margin-top: 8px;
    margin-right: 5px;
    font-family: "Montserrat";
    font-weight: 400;
    line-height: 18.29px;
    flex: 1 0 auto;
}

.botonMedida:hover {
    height: 30px;
    font-size: 15px;
    border: none;
    background: var(--Gris, rgba(51, 68, 127, 1));
    margin-top: 8px;
    margin-right: 5px;
    font-family: "Montserrat";
    font-weight: 400;
    line-height: 18.29px;
    flex: 1 0 auto;
}

.tabla {
    margin-top: 100px;
    margin-left: 17%;
    width: 66%;
}

.tabla p {
    font-family: "Montserrat";
    font-size: 28px;
    font-weight: 500;
    line-height: 34.13px;
    text-align: left;
}

#cantidad {
    width: 60px;
}

.selects {
    border-radius: 0%;
    background-color: rgba(245, 245, 245, 1);
    border: 1px solid rgba(204, 204, 204, 1);
}

.encabezado {
    background: rgba(51, 68, 127, 1);
    color: white;
    font-family: "Montserrat";
    font-weight: 500;
    font-size: 15px;
}

#agregar {
    border: 1px solid rgba(51, 68, 127, 1);
    background-color: white;
    color: rgba(51, 68, 127, 1);
}

#botonAgregar {
    text-align: right;
}

#agregarProducto {
    border: 1px solid rgba(51, 68, 127, 1);
    color: rgba(51, 68, 127, 1);
    background-color: white;
    width: 275px;
    height: 49px;
    font-family: "Montserrat";
    font-size: 15px;
    font-weight: 500;
    margin-top: 20px;
}

.botones {
    display: flex;
    justify-content: space-between;
}

#verPresupuesto {
    border: none;
    color: white;
    background-color: rgba(51, 68, 127, 1);
    width: 275px;
    height: 49px;
    font-family: "Montserrat";
    font-size: 15px;
    font-weight: 400;
    margin-top: 20px;
}


#imgP {
    width: 496px;
    height: 496px;
    flex-shrink: 0;
}


.imgMinis {
    display: flex;
    flex-direction: column;

}

.imgMinis div {
    width: 80px;
    height: 80px;
    padding-right: 8px;
    padding-bottom: 10px;
    margin: 10px;

}

.imgMinis div img {
    width: 80px;
    height: 80px;

}

.inputCantidad {
    border-radius: 0%;
    background-color: rgba(245, 245, 245, 1);
    border: 1px solid rgba(204, 204, 204, 1);
    height: 38px;
    width: 60px;
}



.productosDestacados {
    height: 800px;
}

.productosD {
    font-size: 35px;
    font-weight: 600;
    text-align: left;
    font-family: "Montserrat", sans-serif;
    margin-left: 17%;
    padding-top: 70px;
}

.carouselP {
    padding-left: 15.5%;
    width: 98rem;
}

.categoria {
    font-size: 14px;
    font-weight: 700;
    font-family: "Montserrat", sans-serif;
    color: #33447F;
    line-height: 17px;
    margin-top: 20px;
    margin-left: 10px;
    text-align: left;

}
.carousel__item{
    width: 288px;
    height: 500px;
}
.producto {
    cursor: pointer;
    width: 288px;
    height: 500px;
    background-color: white;
    color: #33447F;
    border-bottom: 1px solid rgba(147, 147, 147, 0.3);
}



.nombre {
    font-size: 22px;
    color: black;
    font-family: "Montserrat", sans-serif;
    font-weight: 500;
    line-height: 26px;
    margin-left: 10px;
    text-align: left;

}

.producto img {
    width: 288px;
    height: 300px;
}

</style>
