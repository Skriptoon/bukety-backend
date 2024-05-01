export function quantityWords({ one, two, five }, number) {
  const value = Math.abs(number) % 100
  const num = value % 10
  if (value > 10 && value < 20) return five
  if (num > 1 && num < 5) return two
  if (num === 1) return one
  return two
}