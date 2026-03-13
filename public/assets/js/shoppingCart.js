export function addItems(productId, currentQuantity) {
  console.log("ejecutando")

  fetch(`/api/v1/shopping_cart/${productId}`, {
    method: "PUT",
    body: JSON.stringify({
      quantity: currentQuantity + 1,
      userId: userId,
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
}

export function lessItems(productId, currentQuantity) {
  fetch(`/api/v1/shopping_cart/${productId}`, {
    method: "PUT",
    body: JSON.stringify({
      quantity: currentQuantity - 1,
      userId: userId,
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
}

export function removeItems(productId) {
  fetch(`/api/v1/shopping_cart/${productId}`, {
    method: "DELETE",
    body: JSON.stringify({ userId: userId }),
    headers: {
      "Content-Type": "application/json",
    },
  })
}

export function createdItems(userId, productId) {}
