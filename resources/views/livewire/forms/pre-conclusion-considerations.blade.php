<div>
   {{--  <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3">
        <span>* Campos obligatorios</span>
    </div> --}}

    <form wire:submit="save">

        <div class="form-container">
            <div class="form-container__header">
                Consideraciones previas a la conclusión
            </div>

            <div class="form-container__content">
                <h3>Consideraciones fijas:</h3>
                {{-- Texto estático (Legal) --}}
                <div class="space-y-3 mb-6 text-md text-gray-600 text-justify">
                    <p>
                        El valuador no asume ninguna responsabilidad por las condiciones legales que guarda el inmueble
                        de estudio, ya que el presente reporte supone que el propietario mantiene la propiedad en
                        condiciones óptimas.
                    </p>
                    <p>
                        El valuador no está obligado a dar testimonio o acudir a tribunales por haber realizado el
                        presente reporte, a menos que haya acordado previamente con el solicitante. La información, los
                        estimados y valores asentados en el reporte se obtuvieron de fuentes consideradas confiables y
                        correctas. Se analizaron los valores obtenidos en el presente avalúo y en función de los
                        factores de comercialización y a las condiciones que actualmente prevalecen en el mercado
                        inmobiliario de esta zona, se llega a las siguientes conclusiones:
                    </p>
                </div>

                {{-- Textarea --}}
                <flux:field class="w-full">
                    <h3>Consideraciones Adicionales:</h3>
                    <flux:textarea class="h-64" wire:model="additionalConsiderations" />
                    <flux:error name="additionalConsiderations" />
                </flux:field>

            </div>
        </div>

        {{-- Botón limpio y solitario --}}
        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">
            Guardar datos
        </flux:button>

    </form>
</div>
