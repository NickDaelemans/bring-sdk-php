# Bring Shopping List PHP SDK

## How to install

Simply run ``composer require nickdaelemans/bring-sdk``

## How to use

### Example usage
```
// Initiate the BringApi class with your e-mailaddress and password.
$bring = new BringApi('info@example.com', 'PASSWORD');
$bring->login();

// Get all lists for the logged in user.
$lists = $bring->getLists();

// Get all items from a list.
$list_items = $bring->getItemsFromList('536bb7f3-e3f7-4b7f-af05-253cc47b1dd5');

// Add item to the list using the list's uuid.
$bring->addItem('536bb7f3-e3f7-4b7f-af05-253cc47b1dd5', 'Item name');
```