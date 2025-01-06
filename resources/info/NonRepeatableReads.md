--- Non-Repeatable Reads Simulation ---

**Example**:  
One transaction reads the same data twice, but another transaction changes the data in between. 
This causes the second read to return a different value than the first, which leads to inconsistent results.

- Transaction A reads a balance of $1,000.
- Transaction B updates the balance to $1,200 and commits.
- Transaction A reads the balance again and sees the updated value of $1,200.

### Non-Repeatable Reads in Different Isolation Levels

| Transaction Type | Non-Repeatable Reads Allowed |
|------------------|------------------------------|
| READ UNCOMMITTED | Yes                          |
| READ COMMITTED   | Yes                          |
| REPEATABLE READ  | No                           |
| SERIALIZABLE     | No                           |

---
