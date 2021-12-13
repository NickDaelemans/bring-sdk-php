# Bring Shopping List PHP SDK

## How to install
Simply run ``composer require nickdaelemans/bring-sdk``

## How to use

### Example usage
Initiate the BringApi class with your e-mailaddress and password.
```
// Initiate the BringApi class with your e-mailaddress and password.
$bring = new BringApi('info@example.com', 'PASSWORD');
$bring->login();
// Add item to the list using the list's uuid.
$bring->addItem('{list_uuid}', 'Item name');

```