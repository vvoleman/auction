<template>
    <transition name="fade">
        <div @keydown.esc="close" class="modal-mask" v-show="true" transition="modal">
            <div class="modal-wrapper">
                <div class="modal-container col-md-8 col-xl-6 col-10">
                    <div class="modal-header">
                        <slot name="header">default header</slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">default body</slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-danger" @click="close">Zavřít</button>
                            <button class="btn btn-success" @click="save">Uložit</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "modal",
        methods: {
            close() {
                this.$emit('close');
            },
            save() {
                this.$emit('save');
            }
        },
        mounted() {
            document.addEventListener('keyup', (evt) => {
                if (evt.keyCode === 27) {
                    this.close();
                }
            });
        }
    }
</script>

<style scoped>
    body {
        padding: 4rem;
    }

    [v-cloak] {
        display: none;
    }

    .modal-mask {
        z-index: 9988;
        position: fixed;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
        background-color: rgba(0, 0, 0, 0.5);
        display: table;
        transition: opacity 0.3s ease;
    }
    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        margin: 0px auto;
        padding: 20px 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
        transition: all 0.3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
        height: 400px;
        overflow: auto;
    }

    .modal-button {
        float: right;
    }

    .modal-enter,
    .modal-leave {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave .modal-container {
        transform: scale(1.1);
    }

    /*
    .modal-backdrop {
        position: fixed;
        margin:auto;
        background-color: rgba(0, 0, 0, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal {
        background: #FFFFFF;
        box-shadow: 2px 2px 20px 1px;
        overflow-x: auto;
        display: flex;
        flex-direction: column;
    }

    .modal-header,
    .modal-footer {
        padding: 15px;
        display: flex;
    }

    .modal-header {
        border-bottom: 1px solid #eeeeee;
        color: #4AAE9B;
        justify-content: space-between;
    }

    .modal-footer {
        border-top: 1px solid #eeeeee;
        justify-content: flex-end;
    }

    .modal-body {
        position: relative;
        overflow: auto;
        padding: 20px 10px;
    }

    .btn-close {
        border: none;
        font-size: 20px;
        padding: 20px;
        cursor: pointer;
        font-weight: bold;
        color: #4AAE9B;
        background: transparent;
    }

    .btn-green {
        color: white;
        background: #4AAE9B;
        border: 1px solid #4AAE9B;
        border-radius: 2px;
    }*/
</style>
