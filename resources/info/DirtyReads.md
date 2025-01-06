--- Dirty Reads Simulation ---

**Example**:  
One transaction reads data that another transaction has changed but hasn’t committed yet. 
If the second transaction rolls back, the first transaction ends up with incorrect or "dirty" data.

- Transaction B updates a customer balance from $1,000 to $1,200 but hasn't committed the changes yet.
- Transaction A reads the updated balance $1,200.
- If Transaction B fails and rolls back, the balance should be $1,000, but Transaction A has already read the incorrect data — $1,200.

### Dirty Reads in Different Isolation Levels

| Transaction Type | Dirty Reads Allowed |
|------------------|---------------------|
| READ UNCOMMITTED | Yes                 |
| READ COMMITTED   | No                  |
| REPEATABLE READ  | No                  |
| SERIALIZABLE     | No                  |

