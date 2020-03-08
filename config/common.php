<?php

return [
    'inserted_coins_key' => "current_coins",
    'available_change_key' => "available_change",
    'available_items' => "items",

    'error_payment_coin_required' => 'Coin field is required',
    'error_payment_coin_value' => 'Valid coins are 0.05, 0.10, 0.25 and 1',

    'error_inventory_item_name_required' => 'item_name is required field',
    'error_inventory_item_name_string' => 'item_name must be string',
    'error_inventory_item_price_required' => 'item_price is required field',
    'error_inventory_item_price_numeric' => 'item_price must be numeric and greater then 0',
    'error_inventory_item_count_required' => 'item_count is required field',
    'error_inventory_item_count_numeric' => 'item_count must be numeric and greater than or equal to 0',

    'error_wallet_coins_required' => 'coins is required field',
    'error_wallet_coins_list' => 'coins must be a list',

    'error_not_enough_change' => 'Not enough change to return',
    'error_not_enough_amount' => 'Amount is not enough',
    'error_not_enough_amount_inventory' => 'Amount is less or not enough inventory',
];
