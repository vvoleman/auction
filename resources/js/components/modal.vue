<template>
    <transition name="fade">
        <div @keydown.esc="close" class="modal-backdrop">
            <div class="modal">
                <header class="modal-header">
                    <slot name="header">
                        This is the default tile!

                        <button
                                type="button"
                                class="btn-close"
                                @click="close"
                        >
                            x
                        </button>
                    </slot>
                </header>
                <section class="modal-body">
                    <slot name="body">
                        I'm the default body!
                    </slot>
                </section>
                <footer class="modal-footer">
                    <slot name="footer">
                        <button type="button" class="btn-danger btn" @click="close">
                            Zavřít
                        </button>

                        <button type="button" class="btn btn-green" @click="save">
                            Uložit
                        </button>
                    </slot>
                </footer>
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
            save(){
                this.$emit('save');
            }
        },
        mounted(){
            document.addEventListener('keyup', (evt) => {
                if (evt.keyCode === 27) {
                    this.close();
                }
            });
        }
    }
</script>

<style scoped>
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
    }
</style>
