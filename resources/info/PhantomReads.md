--- Phantom Reads Simulation ---

**Example**:  
A transaction reads rows matching a condition, but another transaction inserts new rows that 
also match the condition before the first transaction finishes.

- Transaction A reads all customers with a balance greater than $500, finding 1 customer.
- Transaction B adds a new customer named "Jane Doe 2" with a balance of $900 and commits.
- Transaction A re-reads the customers with a balance greater than $500 and now finds 2 customers.
- The newly added customer creates a "phantom" because it wasn't visible during the first read but appears during the second.


### Phantom Reads in Different Isolation Levels

| Transaction Type | Phantom Reads Allowed  |
|------------------|------------------------|
| READ UNCOMMITTED | Yes                    |
| READ COMMITTED   | Yes                    |
| REPEATABLE READ  | Yes                    |
| SERIALIZABLE     | No                     |

---

Key Notes on Isolation Levels:
- REPEATABLE READ: Ensures no changes to the rows initially read by Transaction A, but it does not prevent the appearance of new rows (phantoms).
- SERIALIZABLE: Ensures that no phantoms appear by blocking conflicting transactions, effectively treating all transactions as if they occurred sequentially.
