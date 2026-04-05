<div class="input-group mt-2">
    <input wire:keydown.enter="updateQty({{$item->id}}, $event.target.value )" data-kioskboard-type="numpad" type="number" class="form-control" placeholder="">
    <div id="input-group-price" class="input-group-text">
        <i class="fas fa-keyboard fa-lg"></i>
    </div>
</div>